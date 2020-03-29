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
