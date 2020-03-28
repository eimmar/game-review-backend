<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer\Review;

use App\Eimmar\GameSpotBundle\DTO\Review\GameReview;
use App\Eimmar\GameSpotBundle\Service\Transformer\AbstractDTOTransformer;

class GameReviewTransformer extends AbstractDTOTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(\stdClass $response): GameReview
    {
        return new GameReview($response->id, $response->name, $response->api_detail_url, $response->site_detail_url);
    }
}
