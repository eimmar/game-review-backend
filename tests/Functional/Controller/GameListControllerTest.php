<?php

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\DataFixtures\GameFixture;
use App\DataFixtures\GameListFixture;
use App\DataFixtures\UserFixture;
use App\Entity\Game;
use App\Entity\GameList;
use App\Entity\User;
use App\Tests\WebTestCase;

class GameListControllerTest extends WebTestCase
{
    public function setUpFixtures(): void
    {
        parent::setUpFixtures();
        $this->addFixture(new GameFixture());
        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
        $this->addFixture(new GameListFixture());
    }

    public function testAllForUser()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);

        $client = $this->createClient();
        $client->request('GET', '/api/game-list/user/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, json_decode($client->getResponse()->getContent(), true));

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('GET', '/api/game-list/user/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(6, json_decode($client->getResponse()->getContent(), true));
    }

    public function testNew()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'half-life']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('POST', '/api/game-list/new', [], [], [], '{"user":"'.$user->getId().'","games":["'.$game->getId().'"],"name":"good","privacyType":1}');
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('good', $response['name']);
        $this->assertNotNull($this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'good']));
    }

    public function testShow()
    {
        $gameList = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('GET', '/api/game-list/' . $gameList->getId());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('private', $response['name']);
    }

    public function testEdit()
    {
        $gameList = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('POST', '/api/game-list/edit/' . $gameList->getId(), [], [], [], '{"name":"private edited","privacyType":2}');
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('private edited', $response['name']);
        $this->assertNotNull($this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private edited', 'privacyType' => 2]));
    }

    public function testListsContainingGame()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'game']);

        $client = $this->createClient();
        $client->request('GET', '/api/game-list/containing/game/'.$game->getId().'/user/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(0, json_decode($client->getResponse()->getContent(), true));

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('GET', '/api/game-list/containing/game/'.$game->getId().'/user/' . $user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(1, json_decode($client->getResponse()->getContent(), true));
    }

    public function testAddToList()
    {
        $gameList = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'half-life']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('POST', "/api/game-list/{$gameList->getId()}/add/{$game->getId()}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(
            2,
            $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private'])->getGameListGames()
        );
    }

    public function testRemoveFromList()
    {
        $gameList = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'game']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('POST', "/api/game-list/{$gameList->getId()}/remove/{$game->getId()}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(
            0,
            $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private'])->getGameListGames()
        );
    }

    public function testDelete()
    {
        $gameList = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('DELETE', "/api/game-list/{$gameList->getId()}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNull($this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']));
    }
}
