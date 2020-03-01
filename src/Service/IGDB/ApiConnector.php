<?php

declare(strict_types=1);




namespace App\Service\IGDB;

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
     * @param string $userKey
     * @param HttpClientInterface $httpClient
     */
    public function __construct(string $userKey, HttpClientInterface $httpClient)
    {
        $this->userKey = $userKey;
        $this->httpClient = $httpClient;
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
        $content = json_decode(file_get_contents('../../game-request-response.json'));


        $games = $content;
    }
}
