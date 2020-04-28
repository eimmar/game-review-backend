<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixture extends Fixture
{
    private function getGame(string $name, string $slug, int $externalId, float $rating = null)
    {
        $game = new Game();

        $game->setName($name);
        $game->setSlug($slug);
        $game->setExternalId($externalId);
        $game->setRating($rating);

        return $game;
    }

    public function load(ObjectManager $manager)
    {
        $game1 = $this->getGame('Game', 'game', 1);
        $game2 = $this->getGame('Test', 'test', 2, 50);
        $game3 = $this->getGame('Half life', 'half-life', 3, 80);
        $game4 = $this->getGame('Counter-strike', 'counter-strike', 4);

        $manager->persist($game1);
        $manager->persist($game2);
        $manager->persist($game3);
        $manager->persist($game4);

        $manager->flush();
    }
}
