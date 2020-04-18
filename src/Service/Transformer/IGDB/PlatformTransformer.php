<?php

declare(strict_types=1);

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
            $platform->setSlug($igdbPlatform->getSlug() ?? (string)$igdbPlatform->getId());

            $this->platformCache[$igdbPlatform->getId()] = $platform;
        }

        return $platform;
    }
}
