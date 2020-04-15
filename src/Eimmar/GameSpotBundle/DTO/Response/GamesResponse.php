<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\DTO\Response;

use App\Eimmar\GameSpotBundle\DTO\Game;

class GamesResponse extends Response
{
    /**
     * @return Game[]
     */
    public function getResults(): array
    {
        return $this->results;
    }
}
