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
     * @param int|null $completely
     * @param Game|int|null $game
     * @param int|null $hastly
     * @param int|null $normally
     */
    public function __construct(?int $completely, $game, ?int $hastly, ?int $normally)
    {
        $this->completely = $completely;
        $this->game = $game;
        $this->hastly = $hastly;
        $this->normally = $normally;
    }

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
