<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Friendship;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Repository\FriendshipRepository;
use App\Service\FriendshipService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class FriendshipServiceTest extends TestCase
{
    private Security $security;

    private FriendshipRepository $repository;

    private EntityManager $entityManager;

    private FriendshipService $service;

    public function setUp()
    {
        $this->security = $this->createMock(Security::class);
        $this->repository = $this->createMock(FriendshipRepository::class);
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->entityManager->expects($this->once())->method('getRepository')->willReturn($this->repository);

        $this->service = new FriendshipService($this->entityManager, $this->security);
    }

    public function testShouldFailAddingExistingFriend()
    {
        $user = new User();
        $this->security->method('getUser')->willReturn($user);
        $this->repository->method('findFriendship')->willReturn(new Friendship(new User(), new User()), null);
        $code = 0;

        try {
            $this->service->addFriend(new User());
        } catch (LogicException $e) {
            $code = $e->getCode();
        }
        $this->assertEquals(LogicExceptionCode::FRIENDSHIP_USER_ALREADY_FRIEND, $code);


        try {
            $this->service->addFriend($user);
        } catch (LogicException $e) {
            $code = $e->getCode();
        }
        $this->assertEquals(LogicExceptionCode::INVALID_DATA, $code);

    }

    public function testAddFriend()
    {
        $friend = new User();
        $user = new User();
        $this->security->method('getUser')->willReturn($user);
        $this->repository->method('findFriendship')->willReturn(null);

        $this->assertEquals(new Friendship($user, $friend), $this->service->addFriend($friend));
    }

    public function testRemoveFriend()
    {
        $friend = new User();
        $friendship = new Friendship(new User(), $friend);
        $this->repository->method('findFriendship')->willReturn($friendship);
        $this->security->method('getUser')->willReturn(new User());

        $this->entityManager->expects($this->once())->method('remove')->with($friendship);
        $this->entityManager->expects($this->once())->method('flush');
        $this->service->removeFriendship($friend);
    }

    public function testRemoveFriendWhenNoFriendshipIsFount()
    {
        $friend = new User();
        $this->repository->method('findFriendship')->willReturn(null);
        $this->security->method('getUser')->willReturn(new User());

        $this->entityManager->expects($this->never())->method('flush');
        $this->service->removeFriendship($friend);
    }


    public function testAcceptRequest()
    {
        $friend = new User();
        $friendship = new Friendship(new User(), $friend);
        $this->repository->method('findFriendRequest')->willReturn($friendship, null);
        $this->security->method('getUser')->willReturn(new User());

        $this->assertEquals(FriendshipStatus::ACCEPTED, $this->service->acceptRequest($friend)->getStatus());

        $this->expectException(LogicException::class);
        $this->expectExceptionCode(LogicExceptionCode::INVALID_DATA);
        $this->service->acceptRequest($friend);
    }
}
