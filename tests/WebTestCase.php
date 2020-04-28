<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class WebTestCase extends SymfonyWebTestCase
{
    /**
     * @var ContainerAwareLoader
     */
    private $fixturesLoader;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();
        $this->entityManager = self::$container->get('doctrine')->getManager();
        $this->setUpFixtures();
        $executor = new ORMExecutor($this->entityManager, new ORMPurger($this->entityManager));

        $executor->execute($this->fixturesLoader->getFixtures());
        $this->ensureKernelShutdown();
    }

    /**
     * @return void
     */
    protected function setUpFixtures(): void
    {
        $this->fixturesLoader = new ContainerAwareLoader(self::$container);
    }

    /**
     * @param FixtureInterface $fixture
     */
    protected function addFixture(FixtureInterface $fixture): void
    {
        $this->fixturesLoader->addFixture($fixture);
    }

    /**
     * @param string $username
     * @param string $firewall
     */
    protected function logIn(string $username, string $firewall)
    {
        $client = static::createClient();
        $container = static::$kernel->getContainer();
        $session = $container->get('session');
        $user = self::$kernel->getContainer()
            ->get('doctrine')
            ->getRepository(User::class)
            ->findOneByUsername($username);

        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
    }

    /**
     * @param string $username
     * @param string $password
     * @return KernelBrowser
     */
    protected function createAuthenticatedClient(string $username, string $password)
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            '/api/auth/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => $username, 'password' => $password])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->ensureKernelShutdown();
        $client = $this->createClient();
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
