<?php

declare(strict_types=1);

namespace App\Service\IsThereAnyDeal;

use App\Service\IsThereAnyDeal\Request\GamePrices;
use App\Service\IsThereAnyDeal\Request\RequestInterface;
use App\Service\IsThereAnyDeal\Request\Search;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const SEARCH_URL = 'https://api.isthereanydeal.com/v01/search/search/';
    const GAME_PRICES_URL = 'https://api.isthereanydeal.com/v01/game/prices/';

    /**
     * @var string
     */
    private $userKey;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;


    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
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
     * @param Search $requestBody
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function search(Search $requestBody)
    {
        return json_decode(
            $this->httpClient
                ->request('GET', self::SEARCH_URL, $this->buildOptions($requestBody))
                ->getContent(),
            true
        );
    }

    /**
     * @param GamePrices $requestBody
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function gamePrices(GamePrices $requestBody)
    {
        return json_decode(
            $this->httpClient
                ->request('GET', self::GAME_PRICES_URL, $this->buildOptions($requestBody))
                ->getContent(),
            true
        );
    }
}
