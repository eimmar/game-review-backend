<?php

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

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Tests\Service;


use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\Service\ApiConnector;
use App\Eimmar\IsThereAnyDealBundle\Tests\Data\HttpClientTestResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnectorTest extends TestCase
{
    private ApiConnector $apiConnector;

    private HttpClientInterface $httpClient;

    public function setUp()
    {
        $userKey = 'userKey';
        $this->httpClient = $this->createMock(HttpClientInterface::class);

        $this->apiConnector = new ApiConnector($userKey, $this->httpClient, 0);
    }

    public function testSearch()
    {
        $request = new SearchRequest('Game', 0, null, 'eu2', 'lt', ['steam', 'shop']);
        $responseContents = '{"ok": "OK"}';
        $requestOptions = [
            'query' =>
                [
                    'key' => 'userKey',
                    'q' => 'Game',
                    'region' => 'eu2',
                    'country' => 'lt',
                    'shops' => 'steam,shop',
                    'offset' => 0
                ]
        ];

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::SEARCH_URL, $requestOptions)
            ->willReturn(new HttpClientTestResponse($responseContents));


        $this->assertEquals(json_decode($responseContents, true), $this->apiConnector->search($request));
    }

    public function testGamePrices()
    {
        $request = new GamePricesRequest(['plain1', 'plain2'], 'eu2', 'lt', null, ['exclude'], 0);
        $responseContents = '{"ok": "OK"}';
        $requestOptions = [
            'query' =>
                [
                    'key' => 'userKey',
                    'plains' => 'plain1,plain2',
                    'region' => 'eu2',
                    'country' => 'lt',
                    'exclude' => 'exclude',
                    'added' => 0,
                ]
        ];

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::GAME_PRICES_URL, $requestOptions)
            ->willReturn(new HttpClientTestResponse($responseContents));


        $this->assertEquals(json_decode($responseContents, true), $this->apiConnector->gamePrices($request));
    }
}
