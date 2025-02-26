<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service;

use App\Eimmar\IGDBBundle\DTO\Game;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\Transformer\GameTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const GAMES_URL = 'https://api-v3.igdb.com/games';

    const REVIEWS_URL = 'https://api-v3.igdb.com/private/reviews';

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
    private GameTransformer $responseToGameTransformer;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param GameTransformer $responseToGameTransformer
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient, GameTransformer $responseToGameTransformer)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
        $this->responseToGameTransformer = $responseToGameTransformer;
    }

    /**
     * @param RequestBody $requestBody
     * @return array
     */
    private function buildOptions(RequestBody $requestBody)
    {
        return [
            'headers' => ['user-key' => $this->userKey],
            'body' => $requestBody->unwrap()
        ];
    }

    /**
     * @param RequestBody $requestBody
     * @return Game[]
     */
    public function games(RequestBody $requestBody)
    {
        $response = json_decode(
            $this->httpClient
                ->request('POST', self::GAMES_URL, $this->buildOptions($requestBody))
                ->getContent()
        );

        return array_map([$this->responseToGameTransformer, 'transform'], $response);
    }

    /**
     * @param RequestBody $requestBody
     * @return array
     */
    public function reviews(RequestBody $requestBody): array
    {
        return json_decode(
            $this->httpClient
                ->request('POST', self::REVIEWS_URL, $this->buildOptions($requestBody))
                ->getContent(),
            true
        );
    }
}
