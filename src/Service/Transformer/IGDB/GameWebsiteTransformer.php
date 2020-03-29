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

use App\Entity\Company\Website;
use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class GameWebsiteTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Website[]
     */
    private array $gameWebsiteCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Game\Website $igdbWebsite
     * @return Game\Website
     */
    public function transform($igdbWebsite)
    {
        if (isset($this->gameWebsiteCache[$igdbWebsite->getId()])) {
            $website = $this->gameWebsiteCache[$igdbWebsite->getId()];
        } else {
            $website = $this->entityManager->getRepository(Game\Website::class)->findOneBy(['externalId' => $igdbWebsite->getId()]) ?: new Game\Website();
            $website->setUrl($igdbWebsite->getUrl());
            $website->setExternalId($igdbWebsite->getId());
            $website->setCategory($igdbWebsite->getCategory());
            $website->setTrusted($igdbWebsite->getTrusted());

            $this->gameWebsiteCache[$igdbWebsite->getId()] = $website;
        }

        return $website;
    }
}
