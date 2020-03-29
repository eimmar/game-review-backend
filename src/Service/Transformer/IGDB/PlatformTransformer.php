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

use App\Eimmar\IGDBBundle\DTO\Platform;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class PlatformTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Platform[]
     */
    private array $platformCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Platform $igdbPlatform
     * @return Game\Platform
     */
    public function transform($igdbPlatform)
    {
        if (isset($this->platformCache[$igdbPlatform->getId()])) {
            $platform = $this->platformCache[$igdbPlatform->getId()];
        } else {
            $platform = $this->entityManager->getRepository(Game\Platform::class)->findOneBy(['externalId' => $igdbPlatform->getId()]) ?: new Game\Platform();
            $platform->setExternalId($igdbPlatform->getId());
            $platform->setName($igdbPlatform->getName());
            $platform->setUrl($igdbPlatform->getUrl());
            $platform->setCategory($igdbPlatform->getCategory());
            $platform->setSummary($igdbPlatform->getSummary());
            $platform->setAbbreviation($igdbPlatform->getAbbreviation());

            $this->platformCache[$igdbPlatform->getId()] = $platform;
        }

        return $platform;
    }
}
