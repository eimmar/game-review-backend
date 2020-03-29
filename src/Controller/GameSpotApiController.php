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

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\Service\ApiConnector;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game-spot")
 */
class GameSpotApiController extends BaseApiController
{
    /**
     * @Route("/reviews", name="game_spot_game_reviews_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/reviews", name="game_spot_game_reviews", methods={"POST"})
     * @param ApiConnector $apiConnector
     * @param Request $request
     * @return JsonResponse
     */
    public function reviews(ApiConnector $apiConnector, ApiRequest $request): JsonResponse
    {
        //TODO: Properly deserialize request as ApiRequest without format, fieldList and maybe some other attributes
        $games = $apiConnector->games($request);
        $reviews = $apiConnector->reviews(new ApiRequest('json'));

        return $this->apiResponseBuilder->buildResponse($reviews);
    }
}
