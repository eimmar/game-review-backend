<?php

declare(strict_types=1);

namespace App\Service;

use App\Eimmar\IGDBBundle\DTO\AgeRating as IGDBAgeRating;
use App\Eimmar\IGDBBundle\DTO\Company as IGDBCompany;
use App\Eimmar\IGDBBundle\DTO\Game as IGDBGame;
use App\Eimmar\IGDBBundle\DTO\Platform;
use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Entity\Company\Website;
use App\Entity\Game;
use App\Entity\Game\Company;
use App\Entity\Game\Theme;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class GameTransformer
{
    private EntityManagerInterface $entityManager;

    /**
     * @var Company[]
     */
    private array $companyCache;

    /**
     * @var Game\Genre[]
     */
    private array $genreCache;

    /**
     * @var Game\GameMode[]
     */
    private array $gameModeCache;

    /**
     * @var Game\Platform[]
     */
    private array $platformCache;

    /**
     * @var Game\Theme[]
     */
    private array $themeCache;

    /**
     * @var Game\Website[]
     */
    private array $gameWebsiteCache;

    /**
     * @var Website[]
     */
    private array $companyWebsiteCache;

    /**
     * @var Game\AgeRating[]
     */
    private array $ageRatingCache;

    /**
     * @var Game\Screenshot[]
     */
    private array $screenshotCache;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->ageRatingCache = [];
        $this->companyCache = [];
        $this->genreCache = [];
        $this->gameModeCache = [];
        $this->platformCache = [];
        $this->screenshotCache = [];
        $this->themeCache = [];
        $this->gameWebsiteCache = [];
        $this->companyWebsiteCache = [];
    }

    /**
     * @param string $entityClass
     * @param ResponseDTO[] $identifiableEntities
     * @return Game\AgeRating[]|object[]
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


    public function transform(IGDBGame $igdbGame): Game
    {
        $game = $this->entityManager->getRepository(Game::class)->findOneBy(['externalId' => $igdbGame->getId()]) ?: new Game();

        $game->setName($igdbGame->getName());
        $game->setExternalId($igdbGame->getId());
        $game->setCategory($igdbGame->getCategory());
        $game->setStoryline($igdbGame->getStoryline());
        $game->setSummary($igdbGame->getSummary());
        $game->setRating($igdbGame->getTotalRating());
        $game->setRatingCount($igdbGame->getTotalRatingCount());

        $companies = new ArrayCollection(array_map([$this, 'transformCompany'], $igdbGame->getInvolvedCompanies()));
        $genres = new ArrayCollection(array_map([$this, 'transformGenre'], $igdbGame->getGenres()));
        $gameModes = new ArrayCollection(array_map([$this, 'transformGameMode'], $igdbGame->getGameModes()));
        $platforms = new ArrayCollection(array_map([$this, 'transformPlatform'], $igdbGame->getPlatforms()));
        $themes = new ArrayCollection(array_map([$this, 'transformTheme'], $igdbGame->getThemes()));
        $websites = new ArrayCollection(array_map([$this, 'transformGameWebsite'], $igdbGame->getWebsites()));

        $this->screenshotCache = $this->loadExisting(Game\Screenshot::class, $igdbGame->getScreenshots());
        $screenshots = new ArrayCollection(array_map([$this, 'transformScreenshot'], $igdbGame->getScreenshots()));

        $this->ageRatingCache = $this->loadExisting(Game\AgeRating::class, $igdbGame->getAgeRatings());
        $ageRatings = new ArrayCollection(array_map([$this, 'transformAgeRating'], $igdbGame->getAgeRatings()));

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

    public function transformAgeRating(IGDBAgeRating $igdbAgeRating): Game\AgeRating
    {
        if (isset($this->ageRatingCache[$igdbAgeRating->getId()])) {
            $ageRating = $this->ageRatingCache[$igdbAgeRating->getId()];
        } else {
            $ageRating = new Game\AgeRating();
            $ageRating->setExternalId($igdbAgeRating->getId());
            $ageRating->setSynopsis($igdbAgeRating->getSynopsis());
            $ageRating->setCategory($igdbAgeRating->getCategory());
            $ageRating->setRating($igdbAgeRating->getRating());
        }

        return $ageRating;
    }

    public function transformScreenshot(IGDBGame\Screenshot $igdbScreenshot): Game\Screenshot
    {
        if (isset($this->screenshotCache[$igdbScreenshot->getId()])) {
            $screenshot = $this->screenshotCache[$igdbScreenshot->getId()];
        } else {
            $screenshot = new Game\Screenshot();
            $screenshot->setUrl($igdbScreenshot->getUrl());
            $screenshot->setExternalId($igdbScreenshot->getId());
            $screenshot->setHeight($igdbScreenshot->getHeight());
            $screenshot->setWidth($igdbScreenshot->getWidth());
            $screenshot->setImageId($igdbScreenshot->getImageId());
        }

        return $screenshot;
    }

    public function transformCompany(IGDBGame\InvolvedCompany $igdbInvolvedCompany): Game\Company
    {
        $igdbCompany = $igdbInvolvedCompany->getCompany();

        if (isset($this->companyCache[$igdbCompany->getId()])) {
            $company = $this->companyCache[$igdbCompany->getId()];
        } else {
            $company = $this->entityManager->getRepository(Company::class)->findOneBy(['externalId' => $igdbCompany->getId()]) ?: new Game\Company();

            $company->setName($igdbCompany->getName());
            $company->setExternalId($igdbCompany->getId());
            $company->setDescription($igdbCompany->getDescription());
            $company->setUrl($igdbCompany->getUrl());

            $websites = new ArrayCollection(array_map([$this, 'transformCompanyWebsite'], $igdbCompany->getWebsites()));
            $company->setWebsites($websites);

            $this->companyCache[$igdbCompany->getId()] = $company;
        }

        return $company;
    }

    public function transformGameWebsite(IGDBGame\Website $igdbWebsite): Game\Website
    {
        if (isset($this->gameWebsiteCache[$igdbWebsite->getId()])) {
            $website = $this->gameWebsiteCache[$igdbWebsite->getId()];
        } else {
            $website = $this->entityManager->getRepository(Game\Website::class)->findOneBy(['externalId' => $igdbWebsite->getId()]) ?: new Game\Website();
            $website->setUrl($igdbWebsite->getUrl());
            $website->setExternalId($igdbWebsite->getId());
            $website->setCategory($igdbWebsite->getCategory());
            $website->setTrusted($igdbWebsite->getTrusted());

            $this->gameWebsiteCache[$igdbWebsite->getId()] = $website;
        }

        return $website;
    }

    public function transformCompanyWebsite(IGDBCompany\Website $igdbWebsite): Website
    {
        if (isset($this->companyWebsiteCache[$igdbWebsite->getId()])) {
            $website = $this->companyWebsiteCache[$igdbWebsite->getId()];
        } else {
            $website = $this->entityManager->getRepository(Website::class)->findOneBy(['externalId' => $igdbWebsite->getId()]) ?: new Website();
            $website->setUrl($igdbWebsite->getUrl());
            $website->setExternalId($igdbWebsite->getId());
            $website->setCategory($igdbWebsite->getCategory());
            $website->setTrusted($igdbWebsite->getTrusted());

            $this->companyWebsiteCache[$igdbWebsite->getId()] = $website;
        }

        return $website;
    }

    public function transformGameMode(IGDBGame\GameMode $igdbGameMode): Game\GameMode
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

    public function transformGenre(IGDBGame\Genre $igdbGenre): Game\Genre
    {
        if (isset($this->genreCache[$igdbGenre->getId()])) {
            $genre = $this->genreCache[$igdbGenre->getId()];
        } else {
            $genre = $this->entityManager->getRepository(Game\Genre::class)->findOneBy(['externalId' => $igdbGenre->getId()]) ?: new Game\Genre();
            $genre->setExternalId($igdbGenre->getId());
            $genre->setName($igdbGenre->getName());
            $genre->setUrl($igdbGenre->getUrl());

            $this->genreCache[$igdbGenre->getId()] = $genre;
        }

        return $genre;
    }

    public function transformPlatform(Platform $igdbPlatform): Game\Platform
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

            $this->platformCache[$igdbPlatform->getId()] = $platform;
        }

        return $platform;
    }

    public function transformTheme(IGDBGame\Theme $igdbTheme): Theme
    {
        if (isset($this->themeCache[$igdbTheme->getId()])) {
            $theme = $this->themeCache[$igdbTheme->getId()];
        } else {
            $theme = $this->entityManager->getRepository(Theme::class)->findOneBy(['externalId' => $igdbTheme->getId()]) ?: new Theme();
            $theme->setExternalId($igdbTheme->getId());
            $theme->setUrl($igdbTheme->getUrl());
            $theme->setName($igdbTheme->getName());

            $this->themeCache[$igdbTheme->getId()] = $theme;
        }

        return $theme;
    }
}
