<?php

declare(strict_types=1);

namespace App\Controller;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\Service\ApiConnector;
use App\Service\ApiJsonResponseBuilder;
use App\Service\CacheService;
use App\Service\Transformer\SnakeToCamelCaseTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/any-deal")
 */
class GameDealApiController extends BaseApiController
{
    private ApiConnector $apiConnector;

    private SnakeToCamelCaseTransformer $snakeToCamelCaseTransformer;

    private CacheService $cache;

    /**
     * @param ApiConnector $apiConnector
     * @param SnakeToCamelCaseTransformer $snakeToCamelCaseTransformer
     * @param ApiJsonResponseBuilder $builder
     * @param CacheService $cache
     */
    public function __construct(
        ApiConnector $apiConnector,
        SnakeToCamelCaseTransformer $snakeToCamelCaseTransformer,
        ApiJsonResponseBuilder $builder,
        CacheService $cache
    ) {
        parent::__construct($builder);
        $this->apiConnector = $apiConnector;
        $this->snakeToCamelCaseTransformer = $snakeToCamelCaseTransformer;
        $this->cache = $cache;
    }

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
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function search(SearchRequest $request): JsonResponse {

        $callBack = function (SearchRequest $request) {
            $response = $this->apiConnector->search($request);
            $this->snakeToCamelCaseTransformer->transform($response);

            return $response;
        };

        $response = $this->cache->getItem('isThereAnyDeal', implode('_', $request->unwrap()), $callBack, [$request]);

        return $this->apiResponseBuilder->respond($response);
    }
}
