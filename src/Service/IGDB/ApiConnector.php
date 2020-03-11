<?php

declare(strict_types=1);

namespace App\Service\IGDB;

use App\Service\IGDB\Transformer\GameTransformer;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const GAMES_URL = 'https://api-v3.igdb.com/games';

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
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function games(RequestBody $requestBody)
    {
//        $response = json_decode(
//            $this->httpClient
//                ->request('POST', self::GAMES_URL, $this->buildOptions($requestBody))
//                ->getContent()
//        );
        $response = json_decode(file_get_contents('/home/emarkevicius/Documents/code/bakalauras/game-tracking-backend/game-request-response.json'));

        return array_map([$this->responseToGameTransformer, 'transform'], $response);
    }
}
