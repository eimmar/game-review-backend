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

namespace App\Eimmar\GameSpotBundle\Tests\Service;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use App\Eimmar\GameSpotBundle\Service\Transformer\GameTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ResponseTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ReviewTransformer;
use App\Eimmar\GameSpotBundle\Tests\Service\TestData\HttpClientTestResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConnectorTest extends TestCase
{
    private ApiConnector $apiConnector;

    private MockObject $httpClient;

    private MockObject $responseTransformer;

    public function setUp()
    {
        $userKey = 'userKey';
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->responseTransformer = $this->createMock(ResponseTransformer::class);

        $this->apiConnector = new ApiConnector(
            $userKey,
            $this->httpClient,
            $this->createMock(GameTransformer::class),
            $this->responseTransformer,
            $this->createMock(ReviewTransformer::class),
        );
    }

    public function testReviews()
    {
        $request = new ApiRequest('json', ['title' => 'Due Process Review'], ['publish_date', 'id', 'authors', 'title', 'image', 'score', 'deck', 'good', 'bad', 'body'], 5, 0, 'publish_date:desc');
        $responseContents = file_get_contents(__DIR__ . '/TestData/review-response.json');
        $transformedResponse = new Response('OK', 0, 0, 0, 0, 10, [], '0');

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::REVIEWS_URL . '?api_key=userKey&format=json&field_list=publish_date%2Cid%2Cauthors%2Ctitle%2Cimage%2Cscore%2Cdeck%2Cgood%2Cbad%2Cbody&limit=5&sort=publish_date%3Adesc&filter=title%3ADue+Process+Review')
            ->willReturn(new HttpClientTestResponse($responseContents));

        $this->responseTransformer->expects($this->once())
            ->method('transform')
            ->with(json_decode($responseContents, true))
            ->willReturn($transformedResponse);

        $this->assertEquals($transformedResponse, $this->apiConnector->reviews($request));
    }

    public function testGames()
    {
        $request = new ApiRequest('json', ['title' => 'Due Process Review'], ['publish_date', 'id', 'authors', 'title', 'image', 'score', 'deck', 'good', 'bad', 'body'], 5, 0, 'publish_date:desc');
        $responseContents = file_get_contents(__DIR__ . '/TestData/game-response.json');
        $transformedResponse = new Response('OK', 0, 0, 0, 0, 10, [], '0');

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::GAMES_URL . '?api_key=userKey&format=json&field_list=publish_date%2Cid%2Cauthors%2Ctitle%2Cimage%2Cscore%2Cdeck%2Cgood%2Cbad%2Cbody&limit=5&sort=publish_date%3Adesc&filter=title%3ADue+Process+Review')
            ->willReturn(new HttpClientTestResponse($responseContents));

        $this->responseTransformer->expects($this->once())
            ->method('transform')
            ->with(json_decode($responseContents, true))
            ->willReturn($transformedResponse);

        $this->assertEquals($transformedResponse, $this->apiConnector->games($request));
    }

    public function testArticles()
    {
        $request = new ApiRequest('json', ['title' => 'Due Process Review'], ['publish_date', 'id', 'authors', 'title', 'image', 'score', 'deck', 'good', 'bad', 'body'], 5, 0, 'publish_date:desc');
        $responseContents = file_get_contents(__DIR__ . '/TestData/review-response.json');
        $transformedResponse = new Response('OK', 0, 0, 0, 0, 10, [], '0');

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::ARTICLES_URL . '?api_key=userKey&format=json&field_list=publish_date%2Cid%2Cauthors%2Ctitle%2Cimage%2Cscore%2Cdeck%2Cgood%2Cbad%2Cbody&limit=5&sort=publish_date%3Adesc&filter=title%3ADue+Process+Review')
            ->willReturn(new HttpClientTestResponse($responseContents));

        $this->responseTransformer->expects($this->once())
            ->method('transform')
            ->with(json_decode($responseContents, true))
            ->willReturn($transformedResponse);

        $this->assertEquals($transformedResponse, $this->apiConnector->articles($request));
    }

    public function testVideos()
    {
        $request = new ApiRequest('json', ['title' => 'Due Process Review'], ['publish_date', 'id', 'authors', 'title', 'image', 'score', 'deck', 'good', 'bad', 'body'], 5, 0, 'publish_date:desc');
        $responseContents = file_get_contents(__DIR__ . '/TestData/review-response.json');
        $transformedResponse = new Response('OK', 0, 0, 0, 0, 10, [], '0');

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', ApiConnector::VIDEOS_URL . '?api_key=userKey&format=json&field_list=publish_date%2Cid%2Cauthors%2Ctitle%2Cimage%2Cscore%2Cdeck%2Cgood%2Cbad%2Cbody&limit=5&sort=publish_date%3Adesc&filter=title%3ADue+Process+Review')
            ->willReturn(new HttpClientTestResponse($responseContents));

        $this->responseTransformer->expects($this->once())
            ->method('transform')
            ->with(json_decode($responseContents, true))
            ->willReturn($transformedResponse);

        $this->assertEquals($transformedResponse, $this->apiConnector->videos($request));
    }
}
