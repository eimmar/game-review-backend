<?php

declare(strict_types=1);

namespace App\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\AgeRating as IGDBAgeRating;
use App\Eimmar\IGDBBundle\DTO\Company as IGDBCompany;
use App\Eimmar\IGDBBundle\DTO\Game as IGDBGame;
use App\Eimmar\IGDBBundle\DTO\Platform;
use App\Entity\Company\Website;
use App\Entity\Game;

class GameTransformer
{
//    /**
//     * @param ExternalEntityTrait[] $oldEntries
//     * @param ExternalEntityTrait[] $newEntries
//     */
//    public function filterCollection($oldEntries, $newEntries)
//    {
//        foreach ($newEntries as $entry) {
//            foreach ($oldEntries as $oldEntry) {
//                if ($oldEntry->getExternalId() === $entry->getExternalId()) {
//                }
//            }
//        }
//    }


    public function transform(IGDBGame $igdbGame): Game
    {
        $game = new Game();
        $game->setName($igdbGame->getName());
        $game->setExternalId($igdbGame->getId());
        $game->setCategory($igdbGame->getCategory());
        $game->setCoverImage($igdbGame->getCover()->getUrl());
        $game->setReleaseDate($igdbGame->getFirstReleaseDate());
        $game->setStoryline($igdbGame->getStoryline());
        $game->setSummary($igdbGame->getSummary());
        $game->setRating($igdbGame->getTotalRating());
        $game->setRatingCount($igdbGame->getTotalRatingCount());

        $ageRatings = array_map([$this, 'transformAgeRating'], $igdbGame->getAgeRatings());
        $companies = array_map([$this, 'transformCompany'], $igdbGame->getInvolvedCompanies());
        $genres = array_map([$this, 'transformGenre'], $igdbGame->getGenres());
        $gameModes = array_map([$this, 'transformGameMode'], $igdbGame->getGameModes());
        $platforms = array_map([$this, 'transformPlatform'], $igdbGame->getPlatforms());
        $screenshots = array_map([$this, 'transformScreenshot'], $igdbGame->getScreenshots());
        $themes = array_map([$this, 'transformTheme'], $igdbGame->getThemes());
        $websites = array_map([$this, 'transformGameWebsite'], $igdbGame->getWebsites());

        $game->setAgeRatings($ageRatings);
        $game->setCompanies($companies);
        $game->setGameModes($gameModes);
        $game->setGenres($genres);
        $game->setPlatforms($platforms);
        $game->setScreenshots($screenshots);
        $game->setThemes($themes);
        $game->setWebsites($websites);

//        $game->setTimeToBeatCompletely($igdbGame->getTimeToBeat());
//        $game->setTimeToBeatNormally($igdbGame->getTimeToBeat());
//        $game->setTimeToBeatHastly($igdbGame->getTimeToBeat());


        return $game;
    }

    public function transformAgeRating(IGDBAgeRating $igdbAgeRating): Game\AgeRating
    {
        $ageRating = new Game\AgeRating();
        $ageRating->setExternalId($igdbAgeRating->getId());
        $ageRating->setSynopsis($igdbAgeRating->getSynopsis());
        $ageRating->setCategory($igdbAgeRating->getCategory());
        $ageRating->setRating($igdbAgeRating->getRating());

        return $ageRating;
    }

    public function transformCompany(IGDBCompany $igdbCompany): Game\Company
    {
        $company = new Game\Company();

        $company->setName($igdbCompany->getName());
        $company->setExternalId($igdbCompany->getId());
        $company->setDescription($igdbCompany->getDescription());
        $company->setUrl($igdbCompany->getUrl());

        $websites = array_map([$this, 'transformCompanyWebsite'], $igdbCompany->getWebsites());
        $company->setWebsites($websites);

        return $company;
    }

    public function transformGameWebsite(IGDBGame\Website $igdbWebsite): Game\Website
    {
        $website = new Game\Website();
        $website->setUrl($igdbWebsite->getUrl());
        $website->setExternalId($igdbWebsite->getId());
        $website->setCategory($igdbWebsite->getCategory());
        $website->setTrusted($igdbWebsite->getTrusted());

        return $website;
    }

    public function transformCompanyWebsite(IGDBCompany\Website $igdbWebsite): Website
    {
        $website = new Website();
        $website->setUrl($igdbWebsite->getUrl());
        $website->setExternalId($igdbWebsite->getId());
        $website->setCategory($igdbWebsite->getCategory());
        $website->setTrusted($igdbWebsite->getTrusted());

        return $website;
    }

    public function transformGameMode(IGDBGame\GameMode $igdbGameMode): Game\GameMode
    {
        $gameMode = new Game\GameMode();
        $gameMode->setUrl($igdbGameMode->getUrl());
        $gameMode->setName($igdbGameMode->getName());
        $gameMode->setExternalId($igdbGameMode->getId());

        return $gameMode;
    }

    public function transformGenre(IGDBGame\Genre $igdbGenre): Game\Genre
    {
        $genre = new Game\Genre();
        $genre->setExternalId($igdbGenre->getId());
        $genre->setName($igdbGenre->getName());
        $genre->setUrl($igdbGenre->getUrl());

        return $genre;
    }

    public function transformPlatform(Platform $igdbPlatform): Game\Platform
    {
        $platform = new Game\Platform();
        $platform->setExternalId($igdbPlatform->getId());
        $platform->setName($igdbPlatform->getName());
        $platform->setUrl($igdbPlatform->getUrl());
        $platform->setCategory($igdbPlatform->getCategory());
        $platform->setSummary($igdbPlatform->getSummary());
        $platform->setAbbreviation($igdbPlatform->getAbbreviation());

        return $platform;
    }

    public function transformScreenshot(IGDBGame\Screenshot $igdbScreenshot): Game\Screenshot
    {
        $screenshot = new Game\Screenshot();
        $screenshot->setUrl($igdbScreenshot->getUrl());
        $screenshot->setExternalId($igdbScreenshot->getId());
        $screenshot->setHeight($igdbScreenshot->getHeight());
        $screenshot->setWidth($igdbScreenshot->getWidth());
        $screenshot->setImageId($igdbScreenshot->getImageId());

        return $screenshot;
    }

    public function transformTheme(IGDBGame\Theme $igdbTheme): Game\Theme
    {
        $theme = new Game\Theme();
        $theme->setExternalId($igdbTheme->getId());
        $theme->setUrl($igdbTheme->getUrl());
        $theme->setName($igdbTheme->getName());

        return $theme;
    }
}
