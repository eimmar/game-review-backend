<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

class TimeToBeat
{
    /**
     * @var int|null
     */
    private $completely;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @var int|null
     */
    private $hastly;

    /**
     * @var int|null
     */
    private $normally;

    /**
     * @return int|null
     */
    public function getCompletely(): ?int
    {
        return $this->completely;
    }

    /**
     * @return Game|int|null
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @return int|null
     */
    public function getHastly(): ?int
    {
        return $this->hastly;
    }

    /**
     * @return int|null
     */
    public function getNormally(): ?int
    {
        return $this->normally;
    }
}
