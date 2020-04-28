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

namespace App\Tests\Functional\Controller\Admin;

use App\DataFixtures\UserFixture;
use App\Entity\User;
use App\Tests\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function setUpFixtures(): void
    {
        parent::setUpFixtures();
        $this->addFixture(new UserFixture(self::$kernel->getContainer()->get('fos_user.user_manager')));
    }

    public function testForgotPassword()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'naudotojas1']);
        $this->logIn('admin', 'admin');
        $client = $this->createClient();

        $client->request('GET', '/admin/actions/reset-password-request/' . $user->getId());
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
