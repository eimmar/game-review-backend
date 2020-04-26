<?php

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

declare(strict_types=1);

namespace App\Service\Transformer;

use App\DTO\SearchRequest;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;

class SearchRequestToIGDBRequestTransformer
{
    const FIELD_MAP = [
        'name' => 'name',
        'releaseDate' => 'first_release_date',
        'rating' => 'total_rating',
        'category' => 'category',
        'genre' => 'genres.slug',
        'theme' => 'themes.slug',
        'platform' => 'platforms.slug',
        'gameMode' => 'game_modes.slug',
    ];

    private function transformSlugArrayField(array &$where, SearchRequest $request, string $field)
    {
        if ($value = $request->getFilter($field)) {
            $where[self::FIELD_MAP[$field]] = '= ("' . implode('", "', (array)$value) . '")';
        }
    }

    public function transform(SearchRequest $request)
    {
        $sort = 'first_release_date desc';
        $where = [];
        if ($request->getOrder() && $request->getOrderBy()) {
            $sort = self::FIELD_MAP[$request->getOrderBy()] . ' ' . strtolower($request->getOrder());
        }

        $this->transformSlugArrayField($where, $request, 'genre');
        $this->transformSlugArrayField($where, $request, 'theme');
        $this->transformSlugArrayField($where, $request, 'platform');
        $this->transformSlugArrayField($where, $request, 'gameMode');

        if ($value = $request->getFilter('category')) {
            $where[self::FIELD_MAP['category']] = '= (' . implode(', ', (array)$value) . ')';
        }

        if ($value = $request->getFilter('ratingFrom')) {
            $where['total_rating'] = '>= ' . $value;
        }

        if ($value = $request->getFilter('ratingTo')) {
            $previousVal = isset($where['total_rating']) ? $where['total_rating'] . ' & total_rating ' : '';
            $where['total_rating'] = $previousVal . '<= ' . $value;
        }

        if ($value = $request->getFilter('total_rating_count')) {
            $where['total_rating_count'] = '>= ' . $value;
        }

        if ($value = $request->getFilter('rating_count_from')) {
            $previousVal = isset($where['total_rating_count']) ? $where['total_rating_count'] . ' & total_rating_count ' : '';
            $where['total_rating_count'] = $previousVal . '<= ' . $value;
        }

        if ($value = $request->getFilter('releaseDateFrom')) {
            $where['first_release_date'] = '>= ' . (new \DateTime($value))->getTimestamp();
        }

        if ($value = $request->getFilter('releaseDateTo')) {
            $previousVal = isset($where['first_release_date']) ? $where['first_release_date'] . ' & first_release_date ' : '';
            $where['first_release_date'] = $previousVal . '<= ' . (new \DateTime($value))->getTimestamp();
        }

        if ($request->getOrderBy() === 'rating') {
            $where['total_rating'] = isset($where['total_rating']) ? $where['total_rating'] . ' & total_rating != null' : '!= null';
            $where['total_rating_count'] =  isset($where['total_rating_count']) ? $where['total_rating_count'] : '>= 20';
        }

        $where['first_release_date'] = isset($where['first_release_date'])
            ? $where['first_release_date'] . ' & first_release_date != null'
            : '!= null & first_release_date <= ' . (new \DateTime())->getTimestamp();

        return new RequestBody(
            [],
            $where,
            $request->getFilter('query') ? '' : $sort,
            $request->getFilter('query') ?: '',
            $request->getPageSize(),
            $request->getFirstResult()
        );
    }
}
