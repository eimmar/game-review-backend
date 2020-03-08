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
use App\Service\IGDB\DTO\Cover;
use App\Service\IGDB\DTO\Game;
use App\Service\IGDB\DTO\GameMode;
use App\Service\IGDB\DTO\Genre;
use App\Service\IGDB\DTO\InvolvedCompany;
use App\Service\IGDB\DTO\Platform;
use App\Service\IGDB\DTO\PlayerPerspective;
use App\Service\IGDB\DTO\Screenshot;
use App\Service\IGDB\DTO\Theme;
use App\Service\IGDB\DTO\TimeToBeat;
use App\Service\IGDB\DTO\Website;

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
     * @return AgeRating|int|null
     */
    public function transformAgeRating($response)
    {
        if (!is_object($response)) {
            return $response;
        }

        return new AgeRating(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'content_descriptions'), //ContentDescription array
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_cover_url'),
            $this->getProperty($response, 'synopsis')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Cover|int|null
     */
    public function transformCover($response)
    {
        if (!is_object($response)) {
            return $response;
        }

        return new Cover(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new GameMode(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new Platform(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'abbreviation'),
            $this->getProperty($response, 'alternative_name'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'generation'),
            $this->getProperty($response, 'platform_logo'), //entity
            $this->getProperty($response, 'product_family'), //entity
            $this->getProperty($response, 'summary'),
            $this->getProperty($response, 'versions'), //entity
            $this->getProperty($response, 'websites'), //entity
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
        if (!is_object($response)) {
            return $response;
        }

        return new PlayerPerspective(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new Screenshot(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new Theme(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new TimeToBeat(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'completely'),
            $this->getProperty($response, 'game'), // Game
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
        if (!is_object($response)) {
            return $response;
        }

        return new Website(
            $this->getProperty($response, 'id'),
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
        if (!is_object($response)) {
            return $response;
        }

        return new InvolvedCompany(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'company'), // Company
            $this->getProperty($response, 'developer'),
            $this->getProperty($response, 'game'), // Game
            $this->getProperty($response, 'porting'),
            $this->getProperty($response, 'publisher'),
            $this->getProperty($response, 'supporting'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    /**
     * @param \stdClass|int|null $response
     * @return Company|int|null
     */
    public function transformCompany($response)
    {
        if (!is_object($response)) {
            return $response;
        }

        return new Company(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'change_date'),
            $this->getProperty($response, 'change_date_category'),
            $this->getProperty($response, 'changed_company_id'), //entity
            $this->getProperty($response, 'country'),
            $this->getProperty($response, 'description'),
            $this->getProperty($response, 'logo'), //entity
            $this->getProperty($response, 'parent'), // Company
            $this->getProperty($response, 'published'), // Game array
            $this->getProperty($response, 'start_date'),
            $this->getProperty($response, 'websites'), // CompanyWebsite array
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
        if (!is_object($response)) {
            return $response;
        }

        return new Genre(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }

    public function transformGame(\stdClass $response)
    {
        if (!is_object($response)) {
            return $response;
        }

        return new Game(
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'age_ratings'), //entity array
            $this->getProperty($response, 'aggregated_rating'),
            $this->getProperty($response, 'aggregated_rating_count'),
            $this->getProperty($response, 'alternative_names'), //entity array
            $this->getProperty($response, 'artworks'), //entity array
            $this->getProperty($response, 'bundles'), //game array
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'collection'), //entity array
            $this->getProperty($response, 'dlcs'), //game array
            $this->getProperty($response, 'expansions'), //game array
            $this->getProperty($response, 'external_games'), //entity array
            $this->getProperty($response, 'first_release_date'),
            $this->getProperty($response, 'follows'),
            $this->getProperty($response, 'franchise'), //entity
            $this->getProperty($response, 'franchises'), //entity array
            $this->getProperty($response, 'game_engines'), //entity array
            $this->getProperty($response, 'game_modes'), //GameMode array
            $this->getProperty($response, 'genres'), //Genre array
            $this->getProperty($response, 'hypes'),
            $this->getProperty($response, 'involved_companies'), //InvolvedCompany array
            $this->getProperty($response, 'keywords'), //entity array
            $this->getProperty($response, 'multiplayer_modes'), //entity array
            $this->getProperty($response, 'platforms'), //Platform array
            $this->getProperty($response, 'player_perspectives'), //entity array
            $this->getProperty($response, 'popularity'),
            $this->getProperty($response, 'pulse_count'),
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_count'),
            $this->getProperty($response, 'release_dates'), //entity array
            $this->getProperty($response, 'screenshots'), //Screenshot array
            $this->getProperty($response, 'similar_games'), //Game array
            $this->getProperty($response, 'standalone_expansions'), //Game array
            $this->getProperty($response, 'status'),
            $this->getProperty($response, 'storyline'),
            $this->getProperty($response, 'summary'),
            $this->getProperty($response, 'tags'),
            $this->getProperty($response, 'themes'), //Theme array
            $this->getProperty($response, 'total_rating'),
            $this->getProperty($response, 'total_rating_count'),
            $this->getProperty($response, 'version_title'),
            $this->getProperty($response, 'videos'), // entity array
            $this->getProperty($response, 'websites'), // Website array
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updatedAt'),
            $this->getProperty($response, 'createdAt'),
            $this->getProperty($response, 'version_parent'), // Game
            $this->getProperty($response, 'time_to_beat'), //TimeToBeat
            $this->getProperty($response, 'parent_game'), // Game
            $this->getProperty($response, 'cover') // Cover
        );
    }
}
