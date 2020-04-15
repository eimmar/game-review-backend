<?php

declare(strict_types=1);

namespace App\Service;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Service\Transformer\IGDB\GameTransformer;
use Doctrine\ORM\EntityManagerInterface;

class IGDBGameDataUpdater
{
    private EntityManagerInterface $entityManager;

    private GameTransformer $gameTransformer;

    private ApiConnector $apiConnector;

    /**
     * @param EntityManagerInterface $entityManager
     * @param GameTransformer $gameTransformer
     * @param ApiConnector $apiConnector
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        GameTransformer $gameTransformer,
        ApiConnector $apiConnector
    ) {
        $this->entityManager = $entityManager;
        $this->gameTransformer = $gameTransformer;
        $this->apiConnector = $apiConnector;
    }

    public function update()
    {
        $gamesFromApi = $this->apiConnector->games(new RequestBody());
        $games = array_map([$this->gameTransformer, 'transform'], $gamesFromApi);
        array_walk($games, [$this->entityManager, 'persist']);
        $this->entityManager->flush();
    }
}
