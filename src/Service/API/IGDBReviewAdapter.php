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

namespace App\Service\API;

use App\DTO\PaginationRequest;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Service\CacheService;
use App\Service\Transformer\SnakeToCamelCaseTransformer;

class IGDBReviewAdapter
{
    const CACHE_TAG = 'igdb.review';

    const REVIEW_FIELDS = [
        'id',
        'conclusion',
        'content',
        'created_at',
        'introduction',
        'negative_points',
        'positive_points',
        'title',
        'user_rating.*',
        'video.*'
    ];

    private SnakeToCamelCaseTransformer $transformer;

    private CacheService $cache;

    private ApiConnector $apiConnector;


    /**
     * @param SnakeToCamelCaseTransformer $transformer
     * @param ApiConnector $apiConnector
     * @param CacheService $cache
     */
    public function __construct(SnakeToCamelCaseTransformer $transformer, ApiConnector $apiConnector, CacheService $cache)
    {
        $this->transformer = $transformer;
        $this->apiConnector = $apiConnector;
        $this->cache = $cache;
    }

    /**
     * @param int $externalGameId
     * @param PaginationRequest $paginationRequest
     * @return array
     */
    public function getReviews(int $externalGameId, PaginationRequest $paginationRequest): array
    {
        $requestBody = new RequestBody(
            self::REVIEW_FIELDS,
            ['game' => '= ' . $externalGameId],
            'created_at desc',
            '',
            $paginationRequest->getPageSize(),
            $paginationRequest->getFirstResult()
        );

        $callback = function (RequestBody $requestBody) {
            $response = $this->apiConnector->reviews($requestBody);

            return $this->transformer->transform($response);
        };

        return $this->cache->getItem(self::CACHE_TAG, $requestBody->unwrap(), $callback, [$requestBody]);
    }
}
