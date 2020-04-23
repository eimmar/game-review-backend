<?php

declare(strict_types=1);

namespace App\Service\API;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Service\Transformer\IGDB\GameTransformer;
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

    /**
     * @param RequestBody $requestBody
     * @return array
     */
    public function update(RequestBody $requestBody)
    {
        $created = 0;
        $updated = 0;

        if (count($requestBody->getFields()) === 0) {
            $requestBody->setFields(
                ['*',
                    'age_ratings.*',
                    'age_ratings.content_descriptions.*',
                    'involved_companies.*',
                    'involved_companies.company.*',
                    'involved_companies.company.websites.*',
                    'genres.*',
                    'game_modes.*',
                    'platforms.*',
                    'screenshots.*',
                    'themes.*',
                    'websites.*',
                    'cover.*',
                    'release_dates.*'
                ]
            );
        }

        $gamesFromApi = $this->apiConnector->games($requestBody);

        foreach ($gamesFromApi as $game) {
            try {
                $game = $this->gameTransformer->transform($game);
                $this->entityManager->contains($game) ? $updated++ : $created++;
                $this->entityManager->persist($game);
            } catch (Throwable $exception) {}
        }
        $this->entityManager->flush();

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => count($gamesFromApi)
        ];
    }
}
