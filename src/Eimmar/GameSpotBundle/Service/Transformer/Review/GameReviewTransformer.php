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
