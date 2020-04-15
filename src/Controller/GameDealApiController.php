<?php

declare(strict_types=1);

namespace App\Controller;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\Service\ApiConnector;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/any-deal")
 */
class GameDealApiController extends BaseApiController
{
    /**
     * @Route("/game-prices", name="any_deal_game_prices_options", methods={"OPTIONS"})
     * @Route("/search", name="any_deal_search_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/game-prices", name="any_deal_game_prices", methods={"POST"})
     * @param ApiConnector $apiConnector
     * @param GamePricesRequest $request
     * @return JsonResponse
     */
    public function gamePrices(ApiConnector $apiConnector, GamePricesRequest $request): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($apiConnector->gamePrices($request));
    }

    /**
     * @Route("/search", name="any_deal_search", methods={"POST"})
     * @param ApiConnector $apiConnector
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function search(ApiConnector $apiConnector, SearchRequest $request): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($apiConnector->search($request));
    }
}
