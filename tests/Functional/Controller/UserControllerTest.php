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

use App\DataFixtures\UserFixture;
use App\Entity\User;
use App\Tests\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUpFixtures(): void
    {
        parent::setUpFixtures();
        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
    }
    public function testUserIndex()
    {
        $client = $this->createClient();
        $client->request('POST', '/api/user/', [], [], [], '{"pageSize":10,"page":1,"filters":{"query":"naudotojas"}}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(3, json_decode($client->getResponse()->getContent(), true)['items']);
    }

    public function testShow()
    {
        $client = $this->createClient();
        $client->request('GET', '/api/user/naudotojas');
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('naudotojas', $response['username']);
        $this->assertFalse(isset($response['email']));

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request('GET', '/api/user/naudotojas');
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('naudotojas@gmail.com', $response['email']);

        $client->request('GET', '/api/user/naudotojas3');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testChangePassword()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request(
            'POST',
            '/api/user/change-password/' . $user->getId(),
            [],
            [],
            [],
            '{"current_password":"naudotojas","plainPassword":{"first":"root","second":"root"}}'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->createAuthenticatedClient('naudotojas', 'root');
    }

    public function testEdit()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas']);

        $client = $this->createAuthenticatedClient('naudotojas', 'naudotojas');
        $client->request(
            'POST',
            '/api/user/edit/' . $user->getId(),
            [
                'user_edit' => ['firstName' => 'Nenaudotojas', 'lastName' => 'N']
            ],
        );
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Nenaudotojas', $response['firstName']);
        $this->assertNotNull($this->entityManager->getRepository(User::class)->findOneBy(['firstName' => 'Nenaudotojas']));
    }
}
