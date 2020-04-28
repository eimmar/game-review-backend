<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\DataFixtures\FriendshipFixture;
use App\DataFixtures\UserFixture;
use App\Entity\Friendship;
use App\Entity\User;
use App\Enum\FriendshipStatus;
use App\Tests\WebTestCase;

class FriendshipControllerTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUpFixtures(): void
    {
        parent::setUpFixtures();

        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
        $this->addFixture(new FriendshipFixture());
    }

    public function testFriendshipStatus()
    {
        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas1']);

        $client->request('GET', '/api/friendship/get/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(FriendshipStatus::PENDING, json_decode($client->getResponse()->getContent())->status);
    }

    public function testAddFriend()
    {
        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $sender = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas2']);

        $client->request('GET', '/api/friendship/add/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotNull($this->entityManager->getRepository(Friendship::class)->findOneBy(['sender' => $sender, 'receiver' => $user]));
    }

    public function testRemoveFriend()
    {
        $client = $this->createAuthenticatedClient('naudotojas1', 'naudotojas1');
        $sender = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas1']);
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas2']);

        $client->request('GET', '/api/friendship/remove/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNull($this->entityManager->getRepository(Friendship::class)->findOneBy(['sender' => $sender, 'receiver' => $user]));
    }

    public function testAcceptYourOwnFriendRequest()
    {
        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $receiverUser = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas1']);

        $client->request('GET', '/api/friendship/accept/' . $receiverUser->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('null', $client->getResponse()->getContent());
    }

    public function testAcceptFriendRequest()
    {
        $client = $this->createAuthenticatedClient('naudotojas1', 'naudotojas1');
        $sender = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);

        $client->request('GET', '/api/friendship/accept/' . $sender->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(FriendshipStatus::ACCEPTED, json_decode($client->getResponse()->getContent())->status);
    }

    public function testGetFriendships()
    {
        $client = $this->createAuthenticatedClient('naudotojas1', 'naudotojas1');

        $client->request('POST', '/api/friendship/', [], [], [], '{"totalResults":0,"page":1,"pageSize":20,"filters":{"status":1,"search":"naudotojas"}}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, json_decode($client->getResponse()->getContent())->totalResults);
        $this->assertEquals('naudotojas1', json_decode($client->getResponse()->getContent())->items[0]->sender->username);
    }
}
