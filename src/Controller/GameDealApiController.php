<?php

declare(strict_types=1);

namespace App\Controller;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\Service\ApiConnector;
use App\Service\Transformer\SnakeToCamelCaseTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/any-deal")
 */
class GameDealApiController extends BaseApiController
{
    /**
     * @Route("/search", name="any_deal_search_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/search", name="any_deal_search", methods={"POST"})
     * @param ApiConnector $apiConnector
     * @param SearchRequest $request
     * @param SnakeToCamelCaseTransformer $snakeToCamelCaseTransformer
     * @return JsonResponse
     */
    public function search(ApiConnector $apiConnector, SearchRequest $request, SnakeToCamelCaseTransformer $snakeToCamelCaseTransformer): JsonResponse
    {
        $response = $apiConnector->search($request);
        return $this->apiResponseBuilder->buildResponse($snakeToCamelCaseTransformer->transform($response));
    }
}
