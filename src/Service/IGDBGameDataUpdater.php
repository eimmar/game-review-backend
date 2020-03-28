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

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

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
        $games = [];

//        foreach ($gamesFromApi as $game) {
//            try {
//                $games[] = $this->gameTransformer->transform($game);
//            } catch (Throwable $throwable) {
////                echo sprintf("Cannot convert game with external id: %s\n", $game->getId());
//                echo sprintf("%s\n", $throwable->getMessage());
//            }
//        }
        $games = array_map([$this->gameTransformer, 'transform'], $gamesFromApi);

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getCompanyCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getGameWebsiteCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getGameModeCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getCompanyWebsiteCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getGenreCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getThemeCache());
        $this->entityManager->flush();

        array_map([$this->entityManager, 'merge'], $this->gameTransformer->getPlatformCache());
        $this->entityManager->flush();

        array_walk($games, [$this->entityManager, 'merge']);
        $this->entityManager->flush();
    }

    public function merge(Game $game)
    {

        $this->entityManager->initializeObject();
    }
}
