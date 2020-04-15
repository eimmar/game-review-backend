<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\DTO\Response;

use App\Eimmar\GameSpotBundle\DTO\Review;

class ReviewsResponse extends Response
{
    /**
     * @return Review[]
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
