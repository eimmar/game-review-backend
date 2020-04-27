<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\API;

use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\API\IGDBGameAdapter;
use App\Service\CacheService;
use App\Service\Transformer\IGDB\GameTransformer;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class IGDBGameAdapterTest extends TestCase
{
    private IGDBGameAdapter $service;

    private EntityManager $entityManager;

    private GameTransformer $transformer;

    private ApiConnector $apiConnector;

    private CacheService $cache;

    public function setUp()
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->transformer = $this->createMock(GameTransformer::class);
        $this->apiConnector = $this->createMock(ApiConnector::class);
        $this->cache = $this->createMock(CacheService::class);

        $this->service = new IGDBGameAdapter($this->entityManager, $this->transformer, $this->apiConnector, $this->cache, 0);
    }

    public function testFindOneBySlug()
    {
        $game = new Game();
        $game->setName('fromDB');
        $gameFromApi = new Game();
        $gameFromApi->setName('fromApi');

        $repository = $this->createMock(GameRepository::class);
        $this->entityManager->method('getRepository')->willReturn($repository);
        $this->apiConnector->method('games')->willReturn([new \App\Eimmar\IGDBBundle\DTO\Game(1)]);

        $repository->method('findOneRecentlyImported')->willReturn($game, null);
        $this->transformer->method('transform')->willReturn($gameFromApi);

        $this->assertEquals($game,  $this->service->findOneBySlug('slug'));
        $this->assertEquals($gameFromApi,  $this->service->findOneBySlug('slug'));
    }
}
