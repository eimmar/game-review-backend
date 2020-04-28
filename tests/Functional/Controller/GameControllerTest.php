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
use App\Entity\GameList;
use App\Tests\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function setUpFixtures(): void
    {
        parent::setUpFixtures();
        $this->addFixture(new GameFixture());
        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
        $this->addFixture(new GameListFixture());
    }

    public function testIndex()
    {
        $client = $this->createClient();

        $client->request('POST', '/api/game/', [], [], [], '{"pageSize":21,"page":1,"firstResult":0,"orderBy":"rating","order":"asc","filters":{"query":"","ratingFrom":"49"}}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Half life', $response['items'][1]['name']);
    }

    public function testShow()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/game/half-life');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Half life', $response['name']);
    }

    public function testListGames()
    {
        $private = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'private']);
        $friendsOnly = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'friendsOnly']);
        $public = $this->entityManager->getRepository(GameList::class)->findOneBy(['name' => 'public']);

        $client = $this->createClient();

        $client->request('POST', '/api/game/list/' .  $private->getId(), [], [], [], '{"pageSize":21,"page":0,"firstResult":0}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/game/list/' .  $friendsOnly->getId(), [], [], [], '{"pageSize":21,"page":0,"firstResult":0}');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/game/list/' .  $public->getId(), [], [], [], '{"pageSize":21,"page":0,"firstResult":0}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Half life', json_decode($client->getResponse()->getContent())[0]->name);
    }
}
