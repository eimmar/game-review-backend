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

use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class GameModeTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\GameMode[]
     */
    private array $gameModeCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Game\GameMode $igdbGameMode
     * @return Game\GameMode
     */
    public function transform($igdbGameMode)
    {
        if (isset($this->gameModeCache[$igdbGameMode->getId()])) {
            $gameMode = $this->gameModeCache[$igdbGameMode->getId()];
        } else {
            $gameMode = $this->entityManager->getRepository(Game\GameMode::class)->findOneBy(['externalId' => $igdbGameMode->getId()]) ?: new Game\GameMode();
            $gameMode->setUrl($igdbGameMode->getUrl());
            $gameMode->setName($igdbGameMode->getName());
            $gameMode->setExternalId($igdbGameMode->getId());

            $this->gameModeCache[$igdbGameMode->getId()] = $gameMode;
        }

        return $gameMode;
    }
}
