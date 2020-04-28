<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\GameList;
use App\Entity\GameListGame;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use App\Enum\GameListType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameListFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @param string $slug
     * @return Game|object|null
     */
    private function getGame(ObjectManager $manager, string $slug)
    {
        return $manager->getRepository(Game::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * @param ObjectManager $manager
     * @param string $username
     * @return User|object|null
     */
    private function getUser(ObjectManager $manager, string $username)
    {
        return $manager->getRepository(User::class)->findOneBy(['username' => $username]);
    }

    public function load(ObjectManager $manager)
    {
        $user1 = $this->getUser($manager,'naudotojas');

        $game1 = $this->getGame($manager, 'game');
        $game2 = $this->getGame($manager, 'test');
        $game3 = $this->getGame($manager, 'half-life');

        $private = new GameList(GameListType::CUSTOM, $user1);
        $private->setName('private');

        $friendsOnly = new GameList(GameListType::CUSTOM, $user1);
        $friendsOnly->setName('friendsOnly');
        $friendsOnly->setPrivacyType(GameListPrivacyType::FRIENDS_ONLY);

        $public = new GameList(GameListType::CUSTOM, $user1);
        $public->setName('public');
        $public->setPrivacyType(GameListPrivacyType::PUBLIC);

        $manager->persist(new GameListGame($private, $game1));
        $manager->persist(new GameListGame($friendsOnly, $game2));
        $manager->persist(new GameListGame($public, $game3));
        $manager->persist($private);
        $manager->persist($friendsOnly);
        $manager->persist($public);

        $manager->flush();
    }
}
