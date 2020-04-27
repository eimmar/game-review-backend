<?php

namespace App\DataFixtures;

use App\Entity\Friendship;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class FriendshipFixture extends Fixture
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function load(ObjectManager $manager)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);
        $user1 = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas1']);
        $user2 = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas2']);

        $manager->persist(new Friendship($user, $user1));

        $friendship = new Friendship($user1, $user2);
        $friendship->setStatus(FriendshipStatus::ACCEPTED);
        $manager->persist($friendship);

        $manager->flush();
    }
}
