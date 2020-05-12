<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Review;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ReviewVoter extends Voter
{
    const VIEW = 'view';
    const MODIFY = 'modify';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::MODIFY]) || !$subject instanceof Review) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $currentUser = $token->getUser();

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $currentUser);
            case self::MODIFY:
            return $this->canModify($subject, $currentUser);
        }

        throw new LogicException('Invalid attribute!');
    }

    /**
     * @param Review $review
     * @param User|string $user
     * @return bool
     */
    private function canView(Review $review, $user)
    {
        return $review->isApproved() || $review->getUser() === $user;
    }

    /**
     * @param Review $review
     * @param User|string $user
     * @return bool
     */
    private function canModify(Review $review, $user)
    {
        return $review->getUser() === $user;
    }
}
