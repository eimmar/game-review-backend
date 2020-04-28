<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReviewFixture extends Fixture
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

    /**
     * @param User $user
     * @param Game $game
     * @param string $title
     * @param string $comment
     * @param int $rating
     * @param bool $approved
     * @param string $pros
     * @param string $cons
     * @return Review
     */
    private function getReview(User $user, Game $game, string $title, string $comment, int $rating, bool $approved = true, string $pros = '', string $cons = '')
    {
        $review = new Review();
        $review->setUser($user);
        $review->setGame($game);
        $review->setTitle($title);
        $review->setComment($comment);
        $review->setRating($rating);
        $review->setApproved($approved);
        $review->setPros($pros);
        $review->setCons($cons);

        return $review;

    }

    public function load(ObjectManager $manager)
    {
        $user1 = $this->getUser($manager,'naudotojas');

        $game1 = $this->getGame($manager, 'game');
        $game2 = $this->getGame($manager, 'test');

        $review1 = $this->getReview($user1, $game1, 'Review 1', 'comment', 8);
        $review2 = $this->getReview($user1, $game1, 'Review 2', 'comment', 7);
        $review3 = $this->getReview($user1, $game2, 'Review 3', 'comment', 9);

        $manager->persist($review1);
        $manager->persist($review2);
        $manager->persist($review3);

        $manager->flush();
    }
}
