<?php

declare(strict_types=1);

namespace App\Tests\Unit\Security\Checker;

use App\Entity\User;
use App\Exception\NonAdminUserException;
use App\Security\Checker\AdminChecker;
use PHPUnit\Framework\TestCase;

class AdminCheckerTest extends TestCase
{
    private AdminChecker $checker;

    public function setUp()
    {
        $this->checker = new AdminChecker();
    }

    public function testShouldFailPreAuthForNonAdminUser()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->expectException(NonAdminUserException::class);
        $this->checker->checkPreAuth($user);
    }

    public function testShouldFailPostAuthForNonAdminUser()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $this->expectException(NonAdminUserException::class);
        $this->checker->checkPostAuth($user);
    }
}
