<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\API;

use App\Eimmar\GameSpotBundle\DTO\Game;
use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\DTO\Response\GamesResponse;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use App\Service\API\GameSpotAdapter;
use App\Service\CacheService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class GameSpotAdapterTest extends TestCase
{
    private GameSpotAdapter $service;

    private ApiConnector $apiConnector;

    private EntityManager $entityManager;

    private CacheService $cacheService;

    public function setUp()
    {
        $this->apiConnector = $this->createMock(ApiConnector::class);
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->cacheService = $this->createMock(CacheService::class);

        $this->service = new GameSpotAdapter($this->apiConnector, $this->entityManager, $this->cacheService);
    }

    public function testGetAssociation()
    {
        $reflector = new \ReflectionClass($this->service);
        $method = $reflector->getMethod('getAssociation');
        $method->setAccessible(true);
        $game = new Game(null, null, null, null, null, null, null, null, null, 'https://www.gamespot.com/api/images/?filter=association%3A5000-21307');

        $this->assertEquals('5000-21307', $method->invokeArgs($this->service, [$game]));
        $this->assertNull($method->invokeArgs($this->service, [new Game()]));
    }

    public function testGetCriteria()
    {
        $reflector = new \ReflectionClass($this->service);
        $method = $reflector->getMethod('getCriteria');
        $method->setAccessible(true);
        $game = new \App\Entity\Game();
        $game->setGameSpotAssociation('1000');
        $game->setName('Game');

        $this->assertEquals(['title' => 'Game Review'], $method->invokeArgs($this->service, ['reviews', $game]));
        $this->assertEquals(['association' => '1000'], $method->invokeArgs($this->service, ['articles', $game]));
    }

    public function testSetGameSpotAssociation()
    {
        $reflector = new \ReflectionClass($this->service);
        $method = $reflector->getMethod('setGameSpotAssociation');
        $method->setAccessible(true);
        $game = new \App\Entity\Game();
        $game->setName('Game');

        $this->cacheService->method('getItem')->willReturn(
            new GamesResponse('',
                0,
                0,
                0,
                0,
                0,
                [new Game(null, null, null, 'Some Game', null, null, null, null, null, 'https://www.gamespot.com/api/images/?filter=association%3A5000-21307')],
                ''
            ),
            new GamesResponse('',
                0,
                0,
                0,
                0,
                0,
                [new Game(null, null, null, 'Game', null, null, null, null, null, 'https://www.gamespot.com/api/images/?filter=association%3A5000-21307')],
                ''
            )
        );

        $method->invokeArgs($this->service, [$game]);
        $this->assertNull($game->getGameSpotAssociation());

        $method->invokeArgs($this->service, [$game]);
        $this->assertEquals('5000-21307', $game->getGameSpotAssociation());
    }

    public function testGet()
    {
        $response = new GamesResponse('', 0, 0, 0, 0, 0, [new Game()], '');
        $this->cacheService->method('getItem')->willReturn($response);
        $game = new \App\Entity\Game();
        $game->setName('');

        $this->assertEquals(
            [],
            $this->service->get('reviews', $game, new ApiRequest('json', [], [], 10, 0))->getResults()
        );

        $game->setGameSpotAssociation('1000');
        $this->assertEquals($response, $this->service->get('reviews', $game, new ApiRequest('json')));
    }
}
