<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer\Review;

use App\Eimmar\GameSpotBundle\DTO\Review\Release;
use App\Eimmar\GameSpotBundle\Service\Transformer\AbstractDTOTransformer;

class ReleaseTransformer extends AbstractDTOTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(\stdClass $response): Release
    {
        return new Release(
            $response->upc,
            $response->distribution_type,
            $response->id,
            $response->name,
            $response->region,
            $response->platform,
            $response->api_detail_url
        );
    }
}
