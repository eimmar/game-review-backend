<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Service\GameSpot;

use App\Service\GameSpot\DTO\Game;
use App\Service\GameSpot\DTO\Review;
use App\Service\GameSpot\Request\ApiRequest;
use App\Service\GameSpot\Transformer\GameTransformer;
use App\Service\GameSpot\Transformer\ResponseTransformer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const REVIEWS_URL = 'http://www.gamespot.com/api/reviews/';
    const GAMES_URL = 'http://www.gamespot.com/api/games/';

    /**
     * @var string
     */
    private $userKey;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var GameTransformer
     */
    private $responseToGameTransformer;

    /**
     * @var ResponseTransformer
     */
    private $responseTransformer;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param GameTransformer $responseToGameTransformer
     * @param ResponseTransformer $responseTransformer
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient, GameTransformer $responseToGameTransformer, ResponseTransformer $responseTransformer)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
        $this->responseToGameTransformer = $responseToGameTransformer;
        $this->responseTransformer = $responseTransformer;
    }

    /**
     * @param ApiRequest $requestBody
     * @return array
     */
    private function buildOptions(ApiRequest $requestBody)
    {
        return ['query' => array_merge(['api_key' => $this->userKey], $requestBody->unwrap())];
    }

    /**
     * @param ApiRequest $requestBody
     * @return Review|array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function reviews(ApiRequest $requestBody)
    {
        $response = $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::REVIEWS_URL, $this->buildOptions($requestBody))
                    ->getContent()
            )
        );

        return array_map([$this->responseToGameTransformer, 'transformReview'], $response->getResults());
    }

    /**
     * @param ApiRequest $requestBody
     * @return Game[]|array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function games(ApiRequest $requestBody): array
    {
        $response = $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::GAMES_URL, $this->buildOptions($requestBody))
                    ->getContent()
            )
        );

        return array_map([$this->responseToGameTransformer, 'transform'], $response->getResults());
    }
}
