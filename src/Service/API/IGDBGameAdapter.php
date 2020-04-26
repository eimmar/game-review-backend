<?php

declare(strict_types=1);

namespace App\Service\API;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Entity\Game;
use App\Service\CacheService;
use App\Service\Transformer\IGDB\GameTransformer;
use Doctrine\ORM\EntityManagerInterface;

class IGDBGameAdapter
{
    private EntityManagerInterface $entityManager;

    private GameTransformer $gameTransformer;

    private ApiConnector $apiConnector;

    private CacheService $cache;

    private int $dataLifeTime;

    const CACHE_TAG = 'igdb.games';

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
     * @param CacheService $cache
     * @param int $dataLifeTime
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        GameTransformer $gameTransformer,
        ApiConnector $apiConnector,
        CacheService $cache,
        int $dataLifeTime
    ) {
        $this->entityManager = $entityManager;
        $this->gameTransformer = $gameTransformer;
        $this->apiConnector = $apiConnector;
        $this->cache = $cache;
        $this->dataLifeTime = $dataLifeTime;
    }

    /**
     * @param RequestBody $requestBody
     * @return Game[]
     */
    public function findAll(RequestBody $requestBody)
    {
        $requestBody->setFields(self::LIST_FIELDS);

        $callBack = function (RequestBody $requestBody) {
            try {
                $games = $this->apiConnector->games($requestBody);
            } catch (\Exception $e) {
                $games = [];
            }
            $this->gameTransformer->setUseDatabase(false);

            return array_map([$this->gameTransformer, 'transform'], $games);
        };

        return $this->cache->getItem(self::CACHE_TAG, $requestBody->unwrap(), $callBack, [$requestBody]);
    }

    /**
     * @param string $slug
     * @return Game
     */
    public function findOneBySlug(string $slug)
    {
        $game = $this->entityManager->getRepository(Game::class)
            ->findOneRecentlyImported($slug, new \DateTimeImmutable("now -{$this->dataLifeTime} second"));
        if ($game) {
            return $game;
        }

        $requestBody = new RequestBody(self::FIELDS, ['slug' => '= "' . $slug . '"'], '', '', 1, 0);
        $games = $this->apiConnector->games($requestBody);
        if ($games) {
            $this->gameTransformer->setUseDatabase(true);
            $game = $this->gameTransformer->transform($games[0]);
            $game->setImportedAt(new \DateTimeImmutable());
            $this->entityManager->persist($game);
            $this->entityManager->flush();
        }

        return $game;
    }
}
