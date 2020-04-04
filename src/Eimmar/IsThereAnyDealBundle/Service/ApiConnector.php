<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Service;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\RequestInterface;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\Transformer\ResponseTransformer;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const SEARCH_CACHE_TAG = 'isThereAnyDeal.search';
    const GAME_PRICES_CACHE_TAG = 'isThereAnyDeal.search';
    const CACHE_LIFETIME = 86400;

    const SEARCH_URL = 'https://api.isthereanydeal.com/v01/search/search/';
    const GAME_PRICES_URL = 'https://api.isthereanydeal.com/v01/game/prices/';

    /**
     * @var string
     */
    private string $userKey;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    private ResponseTransformer $gamePriceTransformer;

    private TagAwareAdapter $cache;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param ResponseTransformer $responseTransformer
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient, ResponseTransformer $responseTransformer)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
        $this->gamePriceTransformer = $responseTransformer;
        $this->cache = new TagAwareAdapter(new FilesystemAdapter(), new FilesystemAdapter());
    }

    /**
     * @param RequestInterface $requestBody
     * @return array
     */
    private function buildOptions(RequestInterface $requestBody)
    {
        return ['query' => array_merge(['key' => $this->userKey], $requestBody->unwrap())];
    }

    /**
     * @param SearchRequest $requestBody
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function search(SearchRequest $requestBody)
    {
        return $this->cache->get($requestBody->getCacheKey(), function (ItemInterface $item) use ($requestBody) {
            $item->expiresAfter(self::CACHE_LIFETIME);
            $item->tag([self::SEARCH_CACHE_TAG]);

            $response = json_decode(
                $this->httpClient
                    ->request('GET', self::SEARCH_URL, $this->buildOptions($requestBody))
                    ->getContent(),
                true
            );

            return $this->gamePriceTransformer->transform($response);
        });
    }

    /**
     * @param GamePricesRequest $requestBody
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function gamePrices(GamePricesRequest $requestBody)
    {
        return $this->cache->get($requestBody->getCacheKey(), function (ItemInterface $item) use ($requestBody) {
            $item->expiresAfter(self::CACHE_LIFETIME);
            $item->tag([self::GAME_PRICES_CACHE_TAG]);

            $response = json_decode(
                $this->httpClient
                    ->request('GET', self::GAME_PRICES_URL, $this->buildOptions($requestBody))
                    ->getContent(),
                true
            );

            return $this->gamePriceTransformer->transform($response);
        });
    }
}
