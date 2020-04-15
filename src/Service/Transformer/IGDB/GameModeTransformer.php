<?php

declare(strict_types=1);

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
