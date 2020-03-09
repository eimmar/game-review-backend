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


namespace App\Service\IGDB\Transformer;

use App\Service\IGDB\DTO\AgeRating;
use App\Service\IGDB\DTO\Company;
use App\Service\IGDB\DTO\Company\CompanyWebsite;
use App\Service\IGDB\DTO\Game;
use App\Service\IGDB\DTO\Game\GameMode;
use App\Service\IGDB\DTO\Game\Genre;
use App\Service\IGDB\DTO\Game\InvolvedCompany;
use App\Service\IGDB\DTO\Game\PlayerPerspective;
use App\Service\IGDB\DTO\Game\Screenshot;
use App\Service\IGDB\DTO\Game\Theme;
use App\Service\IGDB\DTO\Game\TimeToBeat;
use App\Service\IGDB\DTO\Game\Website;
use App\Service\IGDB\DTO\Platform;

class ResponseToGameTransformer
{

    /**
     * @param \stdClass $object
     * @param string $propertyName
     * @return mixed|null
     */
    private function getProperty(\stdClass $object, string $propertyName)
    {
        return isset($object->$propertyName) ? $object->$propertyName : null;
    }

    /**
     * @param \stdClass|int|null $response
     * @return bool
     */
    private function isNotObject($response)
    {
        return !is_object($response) || !is_int($this->getProperty($response, 'id'));
    }

    /**
     * @param \stdClass|int|null $response
     * @return int|null
     */
    public function transformEntity($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return $this->getProperty($response, 'id');
    }

    /**
     * @param \stdClass|int|null $response
     * @return AgeRating|int|null
     */
    public function transformAgeRating($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new AgeRating(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            array_map([$this, 'transformContentDescription'], (array)$this->getProperty($response, 'content_descriptions')),
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_cover_url'),
            $this->getProperty($response, 'synopsis')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return AgeRating\ContentDescription|int|null
     */
    public function transformContentDescription($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new AgeRating\ContentDescription(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'description')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Cover|int|null
     */
    public function transformCover($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Cover(
            (int)$this->getProperty($response, 'id'),
            $this->transformGame($this->getProperty($response, 'game')),
            $this->getProperty($response, 'alpha_channel'),
            $this->getProperty($response, 'animated'),
            $this->getProperty($response, 'height'),
            $this->getProperty($response, 'image_id'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'width')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return GameMode|int|null
     */
    public function transformGameMode($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new GameMode(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Platform|int|null
     */
    public function transformPlatform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Platform(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'abbreviation'),
            $this->getProperty($response, 'alternative_name'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'generation'),
            $this->transformEntity($this->getProperty($response, 'platform_logo')),
            $this->transformEntity($this->getProperty($response, 'product_family')),
            $this->getProperty($response, 'summary'),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'versions')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return PlayerPerspective|int|null
     */
    public function transformPlayerPerspective($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new PlayerPerspective(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Screenshot|int|null
     */
    public function transformScreenshot($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Screenshot(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'alpha_channel'),
            $this->getProperty($response, 'animated'),
            $this->getProperty($response, 'height'),
            $this->getProperty($response, 'image_id'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'width')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Theme|int|null
     */
    public function transformTheme($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Theme(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return TimeToBeat|int|null
     */
    public function transformTimeToBeat($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new TimeToBeat(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'completely'),
            $this->transformGame($this->getProperty($response, 'game')),
            $this->getProperty($response, 'hastly'),
            $this->getProperty($response, 'normally')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Website|int|null
     */
    public function transformWebsite($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Website(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'game'),
            $this->getProperty($response, 'trusted'),
            $this->getProperty($response, 'url')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return InvolvedCompany|int|null
     */
    public function transformInvolvedCompany($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new InvolvedCompany(
            (int)$this->getProperty($response, 'id'),
            $this->transformCompany($this->getProperty($response, 'company')),
            $this->getProperty($response, 'developer'),
            $this->transformGame($this->getProperty($response, 'game')),
            $this->getProperty($response, 'porting'),
            $this->getProperty($response, 'publisher'),
            $this->getProperty($response, 'supporting'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return CompanyWebsite|int|null
     */
    public function transformCompanyWebsite($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new CompanyWebsite(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'trusted'),
            $this->getProperty($response, 'url')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Company|int|null
     */
    public function transformCompany($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Company(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'change_date'),
            $this->getProperty($response, 'change_date_category'),
            $this->transformEntity($this->getProperty($response, 'changed_company_id')),
            $this->getProperty($response, 'country'),
            $this->getProperty($response, 'description'),
            $this->transformEntity($this->getProperty($response, 'logo')),
            $this->transformCompany($this->getProperty($response, 'parent')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'published')),
            $this->getProperty($response, 'start_date'),
            array_map([$this, 'transformCompanyWebsite'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Genre|int|null
     */
    public function transformGenre($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Genre(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Game|\stdClass
     */
    public function transformGame($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Game(
            (int)$this->getProperty($response, 'id'),
            array_map([$this, 'transformAgeRating'], (array)$this->getProperty($response, 'age_ratings')),
            $this->getProperty($response, 'aggregated_rating'),
            $this->getProperty($response, 'aggregated_rating_count'),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'alternative_names')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'artworks')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'bundles')),
            $this->getProperty($response, 'category'),
            $this->transformEntity($this->getProperty($response, 'collection')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'dlcs')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'expansions')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'external_games')),
            $this->getProperty($response, 'first_release_date'),
            $this->getProperty($response, 'follows'),
            $this->transformEntity($this->getProperty($response, 'franchise')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'franchises')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'game_engines')),
            array_map([$this, 'transformGameMode'], (array)$this->getProperty($response, 'game_modes')),
            array_map([$this, 'transformGenre'], (array)$this->getProperty($response, 'genres')),
            $this->getProperty($response, 'hypes'),
            array_map([$this, 'transformInvolvedCompany'], (array)$this->getProperty($response, 'involved_companies')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'keywords')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'multiplayer_modes')),
            array_map([$this, 'transformPlatform'], (array)$this->getProperty($response, 'platforms')),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'player_perspectives')),
            $this->getProperty($response, 'popularity'),
            $this->getProperty($response, 'pulse_count'),
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_count'),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'release_dates')),
            array_map([$this, 'transformScreenshot'], (array)$this->getProperty($response, 'screenshots')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'similar_games')),
            array_map([$this, 'transformGame'], (array)$this->getProperty($response, 'standalone_expansions')),
            $this->getProperty($response, 'status'),
            $this->getProperty($response, 'storyline'),
            $this->getProperty($response, 'summary'),
            $this->getProperty($response, 'tags'),
            array_map([$this, 'transformTheme'], (array)$this->getProperty($response, 'themes')),
            $this->getProperty($response, 'total_rating'),
            $this->getProperty($response, 'total_rating_count'),
            $this->getProperty($response, 'version_title'),
            array_map([$this, 'transformEntity'], (array)$this->getProperty($response, 'videos')),
            array_map([$this, 'transformWebsite'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at'),
            $this->transformGame($this->getProperty($response, 'version_parent')),
            $this->transformTimeToBeat($this->getProperty($response, 'time_to_beat')),
            $this->transformGame($this->getProperty($response, 'parent_game')),
            $this->transformCover($this->getProperty($response, 'cover'))
        );
    }
}
