<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\DataFixtures\UserFixture;
use App\Entity\User;
use App\Tests\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUpFixtures(): void
    {
        parent::setUpFixtures();

        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
    }

    public function testRegister()
    {
        $client = $this->createClient();
        $client->request('POST', '/api/auth/register', [], [], [], '{"firstName":"Naudotojas","lastName":"Naujas","email":"test@gmail.com","username":"test","password":"root"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertNotNull($this->entityManager->getRepository(User::class)->findOneBy(['username' => 'test']));
    }

    public function testForgotPassword()
    {
        $client = $this->createClient();

        $client->request('POST', '/api/auth/forgot-password', [], [], [], '{"email":"naudotojas1@gmail.com"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/auth/forgot-password', [], [], [], '{"email":"naudotojas@gmail.com"}');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testResetPasswordCheck()
    {
        $client = $this->createClient();

        $client->request('POST', '/api/auth/reset-password-check/token');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api/auth/reset-password-check/invalid');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testReset()
    {
        $client = $this->createClient();

        $client->request('POST', '/api/auth/reset-password/token', [], [], [], '{"plainPassword":{"first":"root","second":"root"}}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
