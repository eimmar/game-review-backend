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


namespace App\Controller;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\Service\ApiConnector;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/any-deal")
 */
class GameDealApiController extends BaseApiController
{
    /**
     * @Route("/game-prices", name="any_deal_game_prices_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/game-prices", name="any_deal_game_prices", methods={"POST"})
     * @param ApiConnector $apiConnector
     * @param Request $request
     * @return JsonResponse
     */
    public function gamePrices(ApiConnector $apiConnector, GamePricesRequest $request): JsonResponse
    {
        //TODO: Properly deserialize request as GamePricesRequest
        return $this->apiResponseBuilder->buildResponse($apiConnector->gamePrices($request));
    }
}
