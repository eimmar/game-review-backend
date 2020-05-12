<?php /** @noinspection PhpParamsInspection */

namespace App\DataFixtures;

use App\Entity\Friendship;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FriendshipFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $userRepository = $manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => 'naudotojas']);
        $user1 = $userRepository->findOneBy(['username' => 'naudotojas1']);
        $user2 = $userRepository->findOneBy(['username' => 'naudotojas2']);

        $manager->persist(new Friendship($user, $user1));

        $friendship = new Friendship($user1, $user2);
        $friendship->setStatus(FriendshipStatus::ACCEPTED);
        $manager->persist($friendship);

        $manager->flush();
    }
}
