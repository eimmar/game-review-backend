<?php

declare(strict_types=1);

namespace App\Tests\Unit\Security\Voter;

use App\Entity\Friendship;
use App\Entity\GameList;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use App\Enum\GameListType;
use App\Security\Voter\GameListVoter;
use App\Service\FriendshipService;
use PHPUnit\Framework\TestCase;

class GameListVoterTest extends TestCase
{
    private GameListVoter $voter;

    private FriendshipService $friendshipService;

    public function setUp()
    {
        $this->friendshipService = $this->createMock(FriendshipService::class);
        $this->voter = new GameListVoter($this->friendshipService);
    }

    public function testCanView()
    {
        $reflector = new \ReflectionClass($this->voter);
        $canView = $reflector->getMethod('canView');
        $canView->setAccessible(true);
        $user = new User();

        $gameList = $user->getGameLists()[0];
        $this->assertTrue($canView->invokeArgs($this->voter, [$gameList, $user]));

        $gameList = new GameList(3, new User());
        $gameList->setPrivacyType(GameListPrivacyType::PUBLIC);
        $this->assertTrue($canView->invokeArgs($this->voter, [$gameList, $user]));

        $otherUser = new User();
        $gameList = new GameList(3, $otherUser);
        $gameList->setPrivacyType(GameListPrivacyType::FRIENDS_ONLY);
        $this->friendshipService->expects($this->any())
            ->method('getFriendship')
            ->willReturn(new Friendship($otherUser, $user), null);
        $this->assertTrue($canView->invokeArgs($this->voter, [$gameList, $user]));
        $this->assertFalse($canView->invokeArgs($this->voter, [$gameList, $user]));

        $gameList->setPrivacyType(GameListPrivacyType::PRIVATE);
        $this->assertFalse($canView->invokeArgs($this->voter, [$gameList, $user]));
    }

    public function testCanUpdate()
    {
        $reflector = new \ReflectionClass($this->voter);
        $canUpdate = $reflector->getMethod('canUpdate');
        $canUpdate->setAccessible(true);
        $user = new User();

        $gameList = $user->getGameLists()[0];
        $this->assertTrue($canUpdate->invokeArgs($this->voter, [$gameList, $user]));

        $gameList->setUser(new User());
        $this->assertFalse($canUpdate->invokeArgs($this->voter, [$gameList, $user]));
    }

    /**
     * @dataProvider canDeleteDataProvider
     * @param User $user
     * @param GameList $gameList
     * @param bool $expected
     */
    public function testCanDelete(User $user, GameList $gameList, bool $expected)
    {
        $reflector = new \ReflectionClass($this->voter);
        $canDelete = $reflector->getMethod('canDelete');
        $canDelete->setAccessible(true);

        $this->assertEquals($expected, $canDelete->invokeArgs($this->voter, [$gameList, $user]));
    }

    /**
     * @return \Generator
     */
    public function canDeleteDataProvider()
    {
        $user = new User();
        $gameList = $user->getGameLists()[0];
        $gameList->setType(GameListType::FAVORITES);
        yield [$user, $gameList, false];

        $gameList = clone $gameList;
        $gameList->setType(GameListType::PLAYING);
        yield [$user, $gameList, false];

        $gameList = clone $gameList;
        $gameList->setType(GameListType::WISHLIST);
        yield [$user, $gameList, false];

        $gameList = clone $gameList;
        $gameList->setType(GameListType::CUSTOM);
        yield [$user, $gameList, true];

        $gameList = clone $gameList;
        $gameList->setUser(new User());
        yield [$user, $gameList, false];
    }
}
