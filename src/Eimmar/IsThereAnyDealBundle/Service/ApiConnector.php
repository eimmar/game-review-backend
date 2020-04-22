<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Service;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\RequestInterface;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
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

    private TagAwareAdapter $cache;

    private int $cacheLifeTime;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param int $cacheLifeTime
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient, int $cacheLifeTime)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
        $this->cache = new TagAwareAdapter(new FilesystemAdapter(), new FilesystemAdapter());
        $this->cacheLifeTime = $cacheLifeTime;
    }

    /**
     * @param RequestInterface $requestBody
     * @return array
     */
    public function buildOptions(RequestInterface $requestBody)
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
            $item->expiresAfter($this->cacheLifeTime);
            $item->tag([self::SEARCH_CACHE_TAG]);

            return json_decode(
                $this->httpClient
                    ->request('GET', self::SEARCH_URL, $this->buildOptions($requestBody))
                    ->getContent(),
                true
            );
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
            $item->expiresAfter($this->cacheLifeTime);
            $item->tag([self::GAME_PRICES_CACHE_TAG]);

            return json_decode(
                $this->httpClient
                    ->request('GET', self::GAME_PRICES_URL, $this->buildOptions($requestBody))
                    ->getContent(),
                true
            );
        });
    }
}
