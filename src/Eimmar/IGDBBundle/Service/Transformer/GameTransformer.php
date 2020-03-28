<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\Game;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\CoverTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\GameModeTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\GenreTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\InvolvedCompanyTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\ScreenshotTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\ThemeTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\WebsiteTransformer;


class GameTransformer extends AbstractTransformer
{
    /**
     * @var AgeRatingTransformer
     */
    private AgeRatingTransformer $ageRatingTransformer;

    /**
     * @var EntityTransformer
     */
    private EntityTransformer $entityTransformer;

    /**
     * @var GameModeTransformer
     */
    private GameModeTransformer $gameModeTransformer;

    /**
     * @var GenreTransformer
     */
    private GenreTransformer $genreTransformer;

    /**
     * @var InvolvedCompanyTransformer
     */
    private InvolvedCompanyTransformer $involvedCompanyTransformer;

    /**
     * @var PlatformTransformer
     */
    private PlatformTransformer $platformTransformer;

    /**
     * @var ScreenshotTransformer
     */
    private ScreenshotTransformer $screenshotTransformer;

    /**
     * @var ThemeTransformer
     */
    private ThemeTransformer $themeTransformer;

    /**
     * @var WebsiteTransformer
     */
    private WebsiteTransformer $websiteTransformer;

    /**
     * @var TimeToBeatTransformer
     */
    private TimeToBeatTransformer $timeToBeatTransformer;

    /**
     * @var CoverTransformer
     */
    private CoverTransformer $coverTransformer;

    /**
     * @param AgeRatingTransformer $ageRatingTransformer
     * @param EntityTransformer $entityTransformer
     * @param GameModeTransformer $gameModeTransformer
     * @param GenreTransformer $genreTransformer
     * @param InvolvedCompanyTransformer $involvedCompanyTransformer
     * @param PlatformTransformer $platformTransformer
     * @param ScreenshotTransformer $screenshotTransformer
     * @param ThemeTransformer $themeTransformer
     * @param WebsiteTransformer $websiteTransformer
     * @param TimeToBeatTransformer $timeToBeatTransformer
     * @param CoverTransformer $coverTransformer
     */
    public function __construct(
        AgeRatingTransformer $ageRatingTransformer,
        EntityTransformer $entityTransformer,
        GameModeTransformer $gameModeTransformer,
        GenreTransformer $genreTransformer,
        InvolvedCompanyTransformer $involvedCompanyTransformer,
        PlatformTransformer $platformTransformer,
        ScreenshotTransformer $screenshotTransformer,
        ThemeTransformer $themeTransformer,
        WebsiteTransformer $websiteTransformer,
        TimeToBeatTransformer $timeToBeatTransformer,
        CoverTransformer $coverTransformer
    ) {
        $this->ageRatingTransformer = $ageRatingTransformer;
        $this->entityTransformer = $entityTransformer;
        $this->gameModeTransformer = $gameModeTransformer;
        $this->genreTransformer = $genreTransformer;
        $this->involvedCompanyTransformer = $involvedCompanyTransformer;
        $this->platformTransformer = $platformTransformer;
        $this->screenshotTransformer = $screenshotTransformer;
        $this->themeTransformer = $themeTransformer;
        $this->websiteTransformer = $websiteTransformer;
        $this->timeToBeatTransformer = $timeToBeatTransformer;
        $this->coverTransformer = $coverTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Game(
            (int)$this->getProperty($response, 'id'),
            array_map([$this->ageRatingTransformer, 'transform'], (array)$this->getProperty($response, 'age_ratings')),
            $this->getProperty($response, 'aggregated_rating'),
            $this->getProperty($response, 'aggregated_rating_count'),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'alternative_names')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'artworks')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'bundles')),
            $this->getProperty($response, 'category'),
            $this->entityTransformer->transform($this->getProperty($response, 'collection')),
            array_map([$this, 'transform'], (array)$this->getProperty($response, 'dlcs')),
            array_map([$this, 'transform'], (array)$this->getProperty($response, 'expansions')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'external_games')),
            $this->getProperty($response, 'first_release_date'),
            $this->getProperty($response, 'follows'),
            $this->entityTransformer->transform($this->getProperty($response, 'franchise')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'franchises')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'game_engines')),
            array_map([$this->gameModeTransformer, 'transform'], (array)$this->getProperty($response, 'game_modes')),
            array_map([$this->genreTransformer, 'transform'], (array)$this->getProperty($response, 'genres')),
            $this->getProperty($response, 'hypes'),
            array_map([$this->involvedCompanyTransformer, 'transform'], (array)$this->getProperty($response, 'involved_companies')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'keywords')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'multiplayer_modes')),
            array_map([$this->platformTransformer, 'transform'], (array)$this->getProperty($response, 'platforms')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'player_perspectives')),
            $this->getProperty($response, 'popularity'),
            $this->getProperty($response, 'pulse_count'),
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_count'),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'release_dates')),
            array_map([$this->screenshotTransformer, 'transform'], (array)$this->getProperty($response, 'screenshots')),
            array_map([$this, 'transform'], (array)$this->getProperty($response, 'similar_games')),
            array_map([$this, 'transform'], (array)$this->getProperty($response, 'standalone_expansions')),
            $this->getProperty($response, 'status'),
            $this->getProperty($response, 'storyline'),
            $this->getProperty($response, 'summary'),
            $this->getProperty($response, 'tags'),
            array_map([$this->themeTransformer, 'transform'], (array)$this->getProperty($response, 'themes')),
            $this->getProperty($response, 'total_rating'),
            $this->getProperty($response, 'total_rating_count'),
            $this->getProperty($response, 'version_title'),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'videos')),
            array_map([$this->websiteTransformer, 'transform'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at'),
            $this->transform($this->getProperty($response, 'version_parent')),
            $this->timeToBeatTransformer->transform($this->getProperty($response, 'time_to_beat')),
            $this->transform($this->getProperty($response, 'parent_game')),
            $this->coverTransformer->transform($this->getProperty($response, 'cover'))
        );
    }
}
