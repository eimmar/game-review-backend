<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service;

use App\Eimmar\GameSpotBundle\DTO\Response\GamesResponse;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\DTO\Response\ReviewsResponse;
use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\Service\Transformer\GameTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ResponseTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ReviewTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const REVIEWS_URL = 'http://www.gamespot.com/api/reviews/';
    const GAMES_URL = 'http://www.gamespot.com/api/games/';
    const ARTICLES_URL = 'http://www.gamespot.com/api/articles/';
    const VIDEOS_URL = 'http://www.gamespot.com/api/videos/';
    const IMAGES_URL = 'http://www.gamespot.com/api/images/';

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
     * @return string
     */
    private function buildOptions(ApiRequest $requestBody)
    {
        return '?' . http_build_query(array_merge(['api_key' => $this->userKey], $requestBody->unwrap()));
    }

    /**
     * @param ApiRequest $requestBody
     * @return ReviewsResponse
     */
    public function reviews(ApiRequest $requestBody)
    {
        return $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::REVIEWS_URL . $this->buildOptions($requestBody))
                    ->getContent(),
                true
            ),
            $this->reviewTransformer
        );
    }

    /**
     * @param ApiRequest $requestBody
     * @return GamesResponse
     */
    public function games(ApiRequest $requestBody)
    {
        return $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::GAMES_URL . $this->buildOptions($requestBody))
                    ->getContent(),
                true
            ),
            $this->gameTransformer
        );
    }

    /**
     * @param ApiRequest $requestBody
     * @return Response
     */
    public function articles(ApiRequest $requestBody)
    {
        return $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::ARTICLES_URL . $this->buildOptions($requestBody))
                    ->getContent(),
                true
            )
        );
    }

    /**
     * @param ApiRequest $requestBody
     * @return Response
     */
    public function videos(ApiRequest $requestBody)
    {
        return $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::VIDEOS_URL . $this->buildOptions($requestBody))
                    ->getContent(),
                true
            )
        );
    }

    /**
     * @param ApiRequest $requestBody
     * @return Response
     */
    public function images(ApiRequest $requestBody)
    {
        return $this->responseTransformer->transform(
            json_decode(
                $this->httpClient
                    ->request('GET', self::IMAGES_URL . $this->buildOptions($requestBody))
                    ->getContent(),
                true
            )
        );
    }
}
