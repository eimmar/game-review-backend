<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\GameList;
use App\Entity\User;
use App\Enum\GameListPrivacyType;
use App\Enum\GameListType;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GameListVoter extends Voter
{
    const VIEW = 'view';
    const UPDATE = 'update';
    const DELETE = 'delete';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::UPDATE, self::DELETE]) || !$subject instanceof GameList) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var GameList $gameList */
        $gameList = $subject;
        /** @var User|string $currentUser */
        $currentUser = $token->getUser();

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($gameList, $currentUser);
            case self::UPDATE:
                return $this->canUpdate($gameList, $currentUser);
            case self::DELETE:
                return $this->canDelete($gameList, $currentUser);
        }

        throw new \LogicException('Invalid attribute!');
    }

    /**
     * @param GameList $gameList
     * @param User|string $user
     * @return bool
     */
    private function canView(GameList $gameList, $user)
    {
        return $gameList->getPrivacyType() === GameListPrivacyType::PUBLIC || $gameList->getUser() === $user;
    }

    /**
     * @param GameList $gameList
     * @param User|string $user
     * @return bool
     */
    private function canUpdate(GameList $gameList, $user)
    {
        return $gameList->getUser() === $user;
    }

    /**
     * @param GameList $gameList
     * @param User|string $user
     * @return bool
     */
    private function canDelete(GameList $gameList, $user)
    {
        return $gameList->getUser() === $user && $gameList->getType() === GameListType::CUSTOM;
    }
}
