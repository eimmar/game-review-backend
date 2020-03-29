<?php

declare(strict_types=1);

namespace App\Service\Transformer\IGDB;

use App\Eimmar\IGDBBundle\DTO\Game as IGDBGame;
use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Entity\ExternalEntityInterface;
use App\Entity\Game;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class GameTransformer implements IGDBTransformerInterface
{
    private EntityManagerInterface $entityManager;

    private AgeRatingTransformer $ageRatingTransformer;

    private CompanyTransformer $companyTransformer;

    private GameModeTransformer $gameModeTransformer;

    private GameWebsiteTransformer $gameWebsiteTransformer;

    private GenreTransformer $genreTransformer;

    private PlatformTransformer $platformTransformer;

    private ScreenshotTransformer $screenshotTransformer;

    private ThemeTransformer $themeTransformer;

    /**
     * @param EntityManagerInterface $entityManager
     * @param AgeRatingTransformer $ageRatingTransformer
     * @param CompanyTransformer $companyTransformer
     * @param GameModeTransformer $gameModeTransformer
     * @param GameWebsiteTransformer $gameWebsiteTransformer
     * @param GenreTransformer $genreTransformer
     * @param PlatformTransformer $platformTransformer
     * @param ScreenshotTransformer $screenshotTransformer
     * @param ThemeTransformer $themeTransformer
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        AgeRatingTransformer $ageRatingTransformer,
        CompanyTransformer $companyTransformer,
        GameModeTransformer $gameModeTransformer,
        GameWebsiteTransformer $gameWebsiteTransformer,
        GenreTransformer $genreTransformer,
        PlatformTransformer $platformTransformer,
        ScreenshotTransformer $screenshotTransformer,
        ThemeTransformer $themeTransformer
    ) {
        $this->entityManager = $entityManager;
        $this->ageRatingTransformer = $ageRatingTransformer;
        $this->companyTransformer = $companyTransformer;
        $this->gameModeTransformer = $gameModeTransformer;
        $this->gameWebsiteTransformer = $gameWebsiteTransformer;
        $this->genreTransformer = $genreTransformer;
        $this->platformTransformer = $platformTransformer;
        $this->screenshotTransformer = $screenshotTransformer;
        $this->themeTransformer = $themeTransformer;
    }

    /**
     * @param string $entityClass
     * @param ResponseDTO[] $identifiableEntities
     * @return ExternalEntityInterface[]
     */
    private function loadExisting(string $entityClass, $identifiableEntities)
    {
        $externalIds = array_map(function (ResponseDTO $entity) {
            return $entity->getId();
        }, $identifiableEntities);

        $existing = [];
        foreach ($this->entityManager->getRepository($entityClass)->findBy(['externalId' => $externalIds]) as $item) {
            $existing[$item->getExternalId()] = $item;
        }

        return $existing;
    }

    /**
     * @param IGDBGame $igdbGame
     * @return Game
     * @throws \Exception
     */
    public function transform($igdbGame)
    {
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['externalId' => $igdbGame->getId()]) ?: new Game();

        $game->setName($igdbGame->getName());
        $game->setExternalId($igdbGame->getId());
        $game->setCategory($igdbGame->getCategory());
        $game->setStoryline($igdbGame->getStoryline());
        $game->setSummary($igdbGame->getSummary());
        $game->setRating($igdbGame->getTotalRating());
        $game->setRatingCount($igdbGame->getTotalRatingCount());

        $companies = new ArrayCollection(array_map([$this->companyTransformer, 'transform'], $igdbGame->getInvolvedCompanies()));
        $genres = new ArrayCollection(array_map([$this->genreTransformer, 'transform'], $igdbGame->getGenres()));
        $gameModes = new ArrayCollection(array_map([$this->gameModeTransformer, 'transform'], $igdbGame->getGameModes()));
        $platforms = new ArrayCollection(array_map([$this->platformTransformer, 'transform'], $igdbGame->getPlatforms()));
        $themes = new ArrayCollection(array_map([$this->themeTransformer, 'transform'], $igdbGame->getThemes()));
        $websites = new ArrayCollection(array_map([$this->gameWebsiteTransformer, 'transform'], $igdbGame->getWebsites()));

        /** @noinspection PhpParamsInspection */
        $this->screenshotTransformer->setCache($this->loadExisting(Game\Screenshot::class, $igdbGame->getScreenshots()));
        $screenshots = new ArrayCollection(array_map([$this->screenshotTransformer, 'transform'], $igdbGame->getScreenshots()));

        /** @noinspection PhpParamsInspection */
        $this->ageRatingTransformer->setCache($this->loadExisting(Game\AgeRating::class, $igdbGame->getAgeRatings()));
        $ageRatings = new ArrayCollection(array_map([$this->ageRatingTransformer, 'transform'], $igdbGame->getAgeRatings()));

        $game->setAgeRatings($ageRatings);
        $game->setCompanies($companies);
        $game->setGameModes($gameModes);
        $game->setGenres($genres);
        $game->setPlatforms($platforms);
        $game->setScreenshots($screenshots);
        $game->setThemes($themes);
        $game->setWebsites($websites);

        if ($igdbGame->getFirstReleaseDate()) {
            $game->setReleaseDate((new DateTime)->setTimestamp($igdbGame->getFirstReleaseDate()));
        }

        if ($igdbGame->getCover() instanceof IGDBGame\Cover) {
            $game->setCoverImage($igdbGame->getCover()->getUrl());
        }
//        $game->setTimeToBeatCompletely($igdbGame->getTimeToBeat());
//        $game->setTimeToBeatNormally($igdbGame->getTimeToBeat());
//        $game->setTimeToBeatHastly($igdbGame->getTimeToBeat());

        return $game;
    }
}
