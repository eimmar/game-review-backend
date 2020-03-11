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


namespace App\Eimmar\GameSpotBundle\Service;

use App\Eimmar\GameSpotBundle\DTO\Game;
use App\Eimmar\GameSpotBundle\DTO\Review;
use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\Service\Transformer\GameTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ResponseTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ReviewTransformer;
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
    private string $userKey;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @var GameTransformer
     */
    private GameTransformer $gameTransformer;

    /**
     * @var ResponseTransformer
     */
    private ResponseTransformer $responseTransformer;

    /**
     * @var ReviewTransformer
     */
    private ReviewTransformer $reviewTransformer;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param GameTransformer $gameTransformer
     * @param ResponseTransformer $responseTransformer
     * @param ReviewTransformer $reviewTransformer
     */
    public function __construct(
        string $userKey,
        HttpClientInterface $httpClient,
        GameTransformer $gameTransformer,
        ResponseTransformer $responseTransformer,
        ReviewTransformer $reviewTransformer
    ) {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
        $this->gameTransformer = $gameTransformer;
        $this->responseTransformer = $responseTransformer;
        $this->reviewTransformer = $reviewTransformer;
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

        return array_map([$this->reviewTransformer, 'transform'], $response->getResults());
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

        return array_map([$this->gameTransformer, 'transform'], $response->getResults());
    }
}
