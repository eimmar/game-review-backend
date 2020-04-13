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


namespace App\Service;

use App\Entity\Game;
use App\Entity\GameList;
use App\Enum\GameListPrivacyType;
use App\Enum\GameListType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Security;

class GameListService
{
    private EntityManagerInterface $entityManager;

    private Security $security;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @param GameList $gameList
     * @param bool $initialized
     * @throws \Exception
     */
    public function validate(GameList $gameList, bool $initialized = true)
    {
        $expr = Criteria::expr();
        $duplicateNameCriteria = Criteria::create()->where($expr->andX(
            ...array_filter([
                $expr->eq('type', GameListType::CUSTOM),
                $expr->eq('name', $gameList->getName()),
                $initialized ? $expr->neq('id', $gameList->getId()) : null
            ])
        ));

        if (
            !in_array($gameList->getType(), [GameListType::FAVORITES, GameListType::WISHLIST, GameListType::PLAYING, GameListType::CUSTOM])
            || !in_array($gameList->getPrivacyType(), [GameListPrivacyType::PRIVATE, GameListPrivacyType::FRIENDS_ONLY, GameListPrivacyType::PUBLIC])
            || $gameList->getUser()->getGameLists()->matching($duplicateNameCriteria)->count()
        ) {
            throw new \Exception();
        }
    }

    /**
     * @param int $type
     * @return GameList
     */
    public function getPredefinedTypeList(int $type): GameList
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserInterface || !in_array($type, [GameListType::FAVORITES, GameListType::WISHLIST, GameListType::PLAYING])) {
            throw new \Exception();
        }

        $list = $this->entityManager->getRepository(GameList::class)->findOneBy(['type' => $type, 'user' => $user]);

        if (!$list) {
            $list = new GameList($type, $user);
        }

        return $list;
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     */
    public function addToList(GameList $gameList, Game $game)
    {
        $gameList->addGame($game);
        $this->validate($gameList);

        $this->entityManager->persist($gameList);
        $this->entityManager->flush();
    }

    /**
     * @param GameList $gameList
     * @param Game $game
     * @return GameList
     */
    public function removeFromList(GameList $gameList, Game $game): GameList
    {
        $gameList->removeGame($game);
        $this->validate($gameList);

        $this->entityManager->persist($gameList);
        $this->entityManager->flush();

        return $gameList;
    }
}
