<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Response\Response;

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
