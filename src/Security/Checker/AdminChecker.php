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

namespace App\Security\Checker;

use App\Entity\User;
use App\Exception\NonAdminUserException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminChecker implements UserCheckerInterface
{
    /**
     * @param UserInterface $user
     */
    private function check(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->hasRole('ROLE_ADMIN') && !$user->hasRole('ROLE_SUPER_ADMIN')) {
            $ex = new NonAdminUserException();
            $ex->setUser($user);
            throw $ex;
        }
    }

    /**
     * @param UserInterface $user
     */
    public function checkPreAuth(UserInterface $user)
    {
        $this->check($user);
    }

    /**
     * @param UserInterface $user
     */
    public function checkPostAuth(UserInterface $user)
    {
        $this->check($user);
    }
}
