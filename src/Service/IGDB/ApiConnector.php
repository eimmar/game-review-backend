<?php

declare(strict_types=1);




namespace App\Service\IGDB;

use App\Service\IGDB\Transformer\ResponseToGameTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnector
{
    const GAMES_URL = 'https://api-v3.igdb.com/games';

    /**
     * @var string
     */
    private $userKey;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var ResponseToGameTransformer
     */
    private $responseToGameTransformer;

    /**
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     * @param ResponseToGameTransformer $responseToGameTransformer
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient, ResponseToGameTransformer $responseToGameTransformer)
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

    public function games(RequestBody $requestBody)
    {
//        $response = $this->httpClient->request('POST', self::GAMES_URL, $this->buildOptions($requestBody));
//        $code = $response->getStatusCode();
//        $content = json_decode($response->getContent());
        $response = json_decode(file_get_contents('/home/emarkevicius/Documents/code/bakalauras/game-tracking-backend/game-request-response.json'));

        $data = array_map([$this->responseToGameTransformer, 'transformGame'], $response);

        return $data;
    }
}
