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


namespace App\Service\GameSpot\Transformer;

use App\Service\GameSpot\Response\Response;

class ResponseTransformer
{
    /**
     * @param \stdClass $response
     * @return Response
     */
    public function transform(\stdClass $response)
    {
        return new Response(
            $response->error,
            $response->limit,
            $response->offset,
            $response->number_of_page_results,
            $response->number_of_total_results,
            $response->status_code,
            $response->results,
            $response->version
        );
    }
}
