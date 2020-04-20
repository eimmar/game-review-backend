<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\Service\IGDBReviewAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/igdb")
 */
class IGDBController extends BaseApiController
{
    /**
     * @Route("/reviews/{id}", name="igdb_game_reviews_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/reviews/{externalGameId}", name="igdb_game_reviews", methods={"POST"})
     * @param IGDBReviewAdapter $reviewAdapter
     * @param int $externalGameId
     * @param PaginationRequest $paginationRequest
     * @return JsonResponse
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function reviews(IGDBReviewAdapter $reviewAdapter, int $externalGameId, PaginationRequest $paginationRequest): JsonResponse
    {
        return $this->apiResponseBuilder->respond($reviewAdapter->getReviews($externalGameId, $paginationRequest));
    }
}
