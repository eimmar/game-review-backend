<?php

declare(strict_types=1);

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


namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const CHANGE_PASSWORD = 'changePassword';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::CHANGE_PASSWORD]) || !$subject instanceof User) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $subject;
        $currentUser = $token->getUser();

        switch ($attribute) {
            case self::CHANGE_PASSWORD:
                return $user === $currentUser;
        }

        throw new \LogicException('Invalid attribute!');
    }
}
