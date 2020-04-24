<?php

declare(strict_types=1);

namespace App\Service\API;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Entity\Game;
use App\Service\Transformer\IGDB\GameTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class IGDBGameAdapter
{
    private EntityManagerInterface $entityManager;

    private GameTransformer $gameTransformer;

    private ApiConnector $apiConnector;

    const FIELDS = ['*',
        'age_ratings.*',
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
    ];

    const LIST_FIELDS = [
        'name',
        'slug',
        'cover.url',
        'summary',
        'first_release_date',
        'category',
        'total_rating',
        'total_rating_count',
    ];

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

    public function findAll(RequestBody $requestBody)
    {
        $requestBody->setFields(self::LIST_FIELDS);
        $this->gameTransformer->setUseDatabase(false);

        return array_map([$this->gameTransformer, 'transform'], $this->apiConnector->games($requestBody));
    }

    public function findOneBySlug(string $slug)
    {
        $game = $this->entityManager->getRepository(Game::class)
            ->findOneBy(['slug' => $slug]);
        if ($game) {
            return $game;
        }

        $requestBody = new RequestBody(self::FIELDS, ['slug' => '= "' . $slug . '"'], '', '', 1, 0);
        $games = $this->apiConnector->games($requestBody);
        if ($games) {
            $this->gameTransformer->setUseDatabase(true);
            $game = $this->gameTransformer->transform($games[0]);
            $this->entityManager->persist($game);
            $this->entityManager->flush();
        }

        return $game;
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
            $requestBody->setFields(self::FIELDS);
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
