<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;

class UserFixture extends Fixture
{
    private UserManagerInterface $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $firstName
     * @param string|null $lastName
     * @param array|string[] $roles
     * @param bool $enabled
     * @return User
     */
    private function createUser(
        string $username,
        string $email,
        string $password,
        string $firstName,
        ?string $lastName = null,
        array $roles = ['ROLE_USER'],
        bool $enabled = true,
        ?string $confirmationToken = null
    ) {
        $user = new User();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);

        $user->setEmail($email);
        $user->setEmailCanonical($email);

        $user->setEnabled($enabled);

        $user->setRoles($roles);

        $user->setFirstName($firstName);
        $user->setLastName($lastName);

        $user->setPlainPassword($password);
        $this->userManager->updatePassword($user);

        if ($confirmationToken) {
            $user->setConfirmationToken($confirmationToken);
            $user->setPasswordRequestedAt(new \DateTime());
        }

        return $user;
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createUser(
            'naudotojas',
            'naudotojas@gmail.com',
            'naudotojas',
            'Naudotojas',
            null,
            ['ROLE_USER'],
            true,
            'token'
        ));
        $manager->persist($this->createUser('naudotojas1', 'naudotojas1@gmail.com', 'naudotojas1', 'Naudotojas1'));
        $manager->persist($this->createUser('naudotojas2', 'naudotojas2@gmail.com', 'naudotojas2', 'Naudotojas2'));
        $manager->persist($this->createUser('naudotojas3', 'naudotojas3@gmail.com', 'naudotojas3', 'Naudotojas3', '', ['ROLE_USER'], false));
        $manager->persist($this->createUser('admin', 'admin@gmail.com', 'admin', 'Admin', '', ['ROLE_ADMIN']));
        $manager->flush();
    }
}
