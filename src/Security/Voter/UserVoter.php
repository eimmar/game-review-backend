<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const CHANGE_PASSWORD = 'changePassword';

    const EDIT = 'edit';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::CHANGE_PASSWORD, self::EDIT]) || !$subject instanceof User) {
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
            case self::EDIT:
                return $user === $currentUser;
        }

        throw new \LogicException('Invalid attribute!');
    }
}
