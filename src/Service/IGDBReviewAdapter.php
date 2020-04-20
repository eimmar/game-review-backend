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

namespace App\Service;

use App\DTO\PaginationRequest;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Eimmar\IGDBBundle\Service\ApiConnector;
use App\Entity\Game;
use App\Service\Transformer\SnakeToCamelCaseTransformer;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Contracts\Cache\ItemInterface;

class IGDBReviewAdapter
{
    const CACHE_TAG = 'igdb.review';

    const CACHE_LIFETIME = 86400;

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

    private TagAwareAdapter $cache;

    private ApiConnector $apiConnector;

    /**
     * @param SnakeToCamelCaseTransformer $transformer
     * @param ApiConnector $apiConnector
     */
    public function __construct(SnakeToCamelCaseTransformer $transformer, ApiConnector $apiConnector)
    {
        $this->transformer = $transformer;
        $this->apiConnector = $apiConnector;
        $this->cache = new TagAwareAdapter(new FilesystemAdapter(), new FilesystemAdapter());
    }

    private function getCacheKey(RequestBody $requestBody)
    {
        return str_replace(['{', '}', '(',')','/','\\','@', ':', ' '], '', self::CACHE_TAG . $requestBody->unwrap());
    }

    private function getCriteria(string $apiCallbackFunc, Game $game): array
    {
        return $apiCallbackFunc === 'reviews' ? ['title' => $game->getName() . ' Review'] : ['association' => $game->getGameSpotAssociation()];
    }

    /**
     * @param int $externalGameId
     * @param PaginationRequest $paginationRequest
     * @return array
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getReviews(int $externalGameId, PaginationRequest $paginationRequest): array
    {
        $requestBody = new RequestBody(
            self::REVIEW_FIELDS,
            'game =' . $externalGameId,
            'created_at desc',
            '',
            $paginationRequest->getPageSize(),
            $paginationRequest->getFirstResult()
        );

        return $this->cache->get(
            $this->getCacheKey($requestBody),
            function (ItemInterface $item) use ($requestBody) {
                $item->expiresAfter(self::CACHE_LIFETIME);
                $item->tag([self::CACHE_TAG]);
                $response = $this->apiConnector->reviews($requestBody);

                return $this->transformer->transform($response);
            }
        );
    }
}
