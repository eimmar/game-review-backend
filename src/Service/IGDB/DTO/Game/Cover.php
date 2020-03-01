<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\ImageTrait;

class Cover
{
    use ImageTrait;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @return Game|int|null
     */
    public function getGame()
    {
        return $this->game;
    }
}
