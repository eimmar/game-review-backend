<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Traits\IdentifiableTrait;

class InvolvedCompany
{
    use TimestampableTrait;
    use IdentifiableTrait;

    /**
     * @var Company|int|null
     */
    private $company;

    /**
     * @var bool|null
     */
    private $developer;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @var bool|null
     */
    private $porting;

    /**
     * @var bool|null
     */
    private $publisher;

    /**
     * @var bool|null
     */
    private $supporting;

    /**
     * @param int $id
     * @param Company|int|null $company
     * @param bool|null $developer
     * @param Game|int|null $game
     * @param bool|null $porting
     * @param bool|null $publisher
     * @param bool|null $supporting
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(int $id, $company, ?bool $developer, $game, ?bool $porting, ?bool $publisher, ?bool $supporting, ?int $createdAt, ?int $updatedAt)
    {
        $this->id = $id;
        $this->company = $company;
        $this->developer = $developer;
        $this->game = $game;
        $this->porting = $porting;
        $this->publisher = $publisher;
        $this->supporting = $supporting;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }

    /**
     * @return Company|int|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return bool|null
     */
    public function getDeveloper(): ?bool
    {
        return $this->developer;
    }

    /**
     * @return Game|int|null
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @return bool|null
     */
    public function getPorting(): ?bool
    {
        return $this->porting;
    }

    /**
     * @return bool|null
     */
    public function getPublisher(): ?bool
    {
        return $this->publisher;
    }

    /**
     * @return bool|null
     */
    public function getSupporting(): ?bool
    {
        return $this->supporting;
    }
}
