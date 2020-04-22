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

namespace App\Eimmar\IGDBBundle\Tests;

use App\Eimmar\IGDBBundle\DTO\Game;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Eimmar\IGDBBundle\Service\Transformer\GameTransformer;
use App\Eimmar\IGDBBundle\Tests\Data\HttpClientTestResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnectorTest extends TestCase
{
    private ApiConnector $apiConnector;

    private HttpClientInterface $httpClient;

    private GameTransformer $gameTransformer;

    public function setUp()
    {
        $userKey = 'userKey';
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->gameTransformer = $this->createMock(GameTransformer::class);

        $this->apiConnector = new ApiConnector($userKey, $this->httpClient, $this->gameTransformer);
    }

    public function testGames()
    {
        $request = new RequestBody(['field1', 'field2'], 'name="game"', 'date desc', 'search', 10, 0);
        $responseContents = '[{"ok": "OK"}]';
        $requestOptions = [
            'headers' => ['user-key' => 'userKey'],
            'body' => 'fields field1,field2;where name="game";sort date desc;limit 10;offset 0;search "search";'
        ];
        $game = new Game(0);

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('POST', ApiConnector::GAMES_URL, $requestOptions)
            ->willReturn(new HttpClientTestResponse($responseContents));

        $this->gameTransformer->expects($this->once())->method('transform')->with(json_decode($responseContents)[0])->willReturn($game);

        $this->assertEquals([$game], $this->apiConnector->games($request));
    }

    public function testReviews()
    {
        $request = new RequestBody(['field1', 'field2'], 'name="game"', 'date desc', 'search', 10, 0);
        $responseContents = '{"ok": "OK"}';
        $requestOptions = [
            'headers' => ['user-key' => 'userKey'],
            'body' => 'fields field1,field2;where name="game";sort date desc;limit 10;offset 0;search "search";'
        ];

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('POST', ApiConnector::REVIEWS_URL, $requestOptions)
            ->willReturn(new HttpClientTestResponse($responseContents));


        $this->assertEquals(json_decode($responseContents, true), $this->apiConnector->reviews($request));
    }
}
