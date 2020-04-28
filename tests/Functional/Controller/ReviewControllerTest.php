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
use App\DataFixtures\ReviewFixture;
use App\DataFixtures\UserFixture;
use App\Entity\Game;
use App\Entity\Review;
use App\Entity\User;
use App\Tests\WebTestCase;

class ReviewControllerTest extends WebTestCase
{
    public function setUpFixtures(): void
    {
        parent::setUpFixtures();
        $this->addFixture(new GameFixture());
        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
        $this->addFixture(new ReviewFixture());
    }
    public function testShowByGame()
    {
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'game']);

        $client = $this->createClient();
        $client->request('POST', '/api/review/game/' . $game->getId(), [], [], [], '{"page":1,"totalResults":0,"pageSize":5}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(2, json_decode($client->getResponse()->getContent(), true)['items']);
    }

    public function testShowByUser()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);

        $client = $this->createClient();
        $client->request('POST', '/api/review/user/' . $user->getId(), [], [], [], '{"page":1,"totalResults":0,"pageSize":5}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, json_decode($client->getResponse()->getContent(), true)['items']);
    }

    public function testNew()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['slug' => 'half-life']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request(
            'POST',
            '/api/review/new',
            [],
            [],
            [],
            '{"game":"'.$game->getId().'","user":"'.$user->getId().'","title":"Good","comment":"Best","rating":"10","pros":["everything"],"cons":["none"]}'
        );
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Good', $response['title']);
        $this->assertNotNull($this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Good']));
    }

    public function testEdit()
    {
        $review = $this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Review 1']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request(
            'POST',
            '/api/review/edit/' . $review->getId(),
            [],
            [],
            [],
            '{"comment":"Review 1","title":"Review 1","pros":[""],"cons":[""],"rating":10}'
        );
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(10, $response['rating']);
        $this->assertNotNull($this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Review 1', 'rating' => 10]));
    }

    public function testShow()
    {
        $review = $this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Review 1']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('GET', '/api/review/' . $review->getId());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Review 1', $response['title']);
    }

    public function testDelete()
    {
        $review = $this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Review 1']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('DELETE', '/api/review/' . $review->getId());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNull($this->entityManager->getRepository(Review::class)->findOneBy(['title' => 'Review 1']));
    }
}
