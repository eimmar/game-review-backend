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

namespace App\Service;

use App\DTO\PaginationRequest;
use App\Entity\Game;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Security\Core\Security;

class ReviewService
{
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param PaginationRequest $request
     * @param User $user
     * @return array
     */
    public function getUserReviews(PaginationRequest $request, User $user)
    {
        $criteria = Criteria::create()
            ->orderBy(['createdAt' => 'DESC'])
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());

        if ($this->security->getUser() !== $user) {
            $criteria->where(Criteria::expr()->eq('approved', true));
        }

        return $user->getReviews()->matching($criteria)->toArray();
    }

    /**
     * @param PaginationRequest $request
     * @param Game $game
     * @return array
     */
    public function getGameReviews(PaginationRequest $request, Game $game)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('approved', true))
            ->andWhere(Criteria::expr()->eq('game', $game))
            ->orderBy(['createdAt' => 'DESC'])
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());

        return $game->getReviews()->matching($criteria)->toArray();
    }
}
