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

use App\Service\IGDB\DTO\Game;

class ResponseToGameTransformer
{
    const GAME_PROPERTIES = [
        'id',
        'age_ratings',
        'aggregated_rating',
        'aggregated_rating_count',
        'alternative_names',
        'bundles',
        'category',
        'collection',
        'cover',
        'dlcs',
        'expansions',
        'external_games',
        'first_release_date',
        'follows',
        'franchise',
        'franchises',
        'game_engines',
        'game_modes',
        'genres',
        'hypes',
        'involved_companies',
        'keywords',
        'multiplayer_modes',
        'parent_page',
        'platforms',
        'player_perspectives',
        'popularity',
        'pulse_count',
        'release_dates',
        'screenshots',
        'similar_games',
        'standalone_expansions',
        'status',
        'storyline',
        'summary',
        'tags',
        'themes',
        'time_to_beat',
        'total_rating',
        'total_rating_count',
        'version_title',
        'videos',
        'websites',
        'name',
        'slug',
        'url',
        'createdAt',
        'updatedAt',
    ];

    /**
     * @param \stdClass $object
     * @param string $propertyName
     * @return mixed|null
     */
    private function getProperty(\stdClass $object, string $propertyName)
    {
        return isset($object->$propertyName) ? $object->$propertyName : null;
    }

    public function transform(\stdClass $gameResponse)
    {
        $rawData = [];

        foreach (self::GAME_PROPERTIES as $property) {
            $value = $this->getProperty($gameResponse, $property);

            if (is_array($value)) {

            } elseif ($value instanceof \stdClass) {

            } else {

            }
        }

        return new Game();
    }
}