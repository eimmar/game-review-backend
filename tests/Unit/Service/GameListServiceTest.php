<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Friendship;
use App\Entity\Game;
use App\Entity\GameList;
use App\Entity\GameListGame;
use App\Entity\User;
use App\Enum\GameListType;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Repository\GameListRepository;
use App\Service\FriendshipService;
use App\Service\GameListService;
use Doctrine\DBAL\Driver\PDOException as DoctrinePDOException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class GameListServiceTest extends TestCase
{
    private EntityManager $entityManager;

    private Security $security;

    private GameListRepository $repository;

    private FriendshipService $friendshipService;

    private GameListService $service;

    public function setUp()
    {
        $this->security = $this->createMock(Security::class);
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->repository = $this->createMock(GameListRepository::class);
        $this->friendshipService = $this->createMock(FriendshipService::class);

        $this->entityManager->method('getRepository')->willReturn($this->repository);

        $this->service = new GameListService($this->entityManager, $this->security, $this->friendshipService);
    }

    public function testCreateList()
    {
        $user = new User();
        $gameList = new GameList(GameListType::CUSTOM, $user);
        $games = [new Game(), new Game()];

        $this->service->createList($gameList, $games);
        $this->assertEquals(2, $gameList->getGameListGames()->count());


        $this->entityManager->method('flush')
            ->willThrowException(new UniqueConstraintViolationException('', new DoctrinePDOException(new \PDOException())));
        $code = 0;
        try {
            $this->service->createList($gameList, $games);
        } catch (LogicException $e) {
            $code = $e->getCode();
        }

        $this->assertEquals(LogicExceptionCode::GAME_LIST_DUPLICATE_NAME, $code);
    }

    public function testRemoveFromList()
    {
        $gameList = new GameList(0, new User());
        $game = new Game();
        $this->repository->method('findOneBy')
            ->willReturn(null, new GameListGame($gameList, $game));

        $this->entityManager->expects($this->once())->method('remove');
        $this->entityManager->expects($this->once())->method('flush');
        $this->service->removeFromList($gameList, $game);
        $this->service->removeFromList($gameList, $game);
    }

    public function testGetUserGameLists()
    {
        $user = new User();

        $this->security->method('getUser')->willReturn($user);
        $this->assertEquals($user->getGameLists(), $this->service->getUserGameLists($user));
    }

    public function testGetUserGameListsForFriend()
    {
        $user = new User();
        $this->security->method('getUser')->willReturn(new User());
        $this->friendshipService->method('getFriendship')->willReturn(new Friendship($user, new User()));

        $this->repository->expects($this->once())->method('findAllVisible')->with($user, true);
        $this->service->getUserGameLists($user);
    }

    public function testGetUserGameListsForRandomUser()
    {
        $user = new User();
        $this->security->method('getUser')->willReturn(new User(), null);
        $this->friendshipService->method('getFriendship')->willReturn(null);

        $this->repository->expects($this->exactly(2))->method('findAllVisible')->with($user, false);
        $this->service->getUserGameLists($user);
        $this->service->getUserGameLists($user);
    }
}
