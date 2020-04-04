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


namespace App\Service\Transformer\IGDB;

use App\Eimmar\IGDBBundle\DTO\AgeRating as IGDBAgeRating;
use App\Entity\Game;

class AgeRatingTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\AgeRating[]
     */
    protected array $ageRatingCache;

    /**
     * @param Game\AgeRating[] $items
     */
    public function setCache($items)
    {
        $this->ageRatingCache = $items;
    }

    /**
     * @param IGDBAgeRating $igdbAgeRating
     * @return Game\AgeRating
     */
    public function transform($igdbAgeRating)
    {
        if (isset($this->ageRatingCache[$igdbAgeRating->getId()])) {
            $ageRating = $this->ageRatingCache[$igdbAgeRating->getId()];
        } else {
            $ageRating = new Game\AgeRating();
        }

        $ageRating->setExternalId($igdbAgeRating->getId());
        $ageRating->setSynopsis($igdbAgeRating->getSynopsis());
        $ageRating->setCategory($igdbAgeRating->getCategory());
        $ageRating->setRating($igdbAgeRating->getRating());

        return $ageRating;
    }
}
