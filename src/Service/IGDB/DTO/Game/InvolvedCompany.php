<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;

class InvolvedCompany
{
    use TimestampableTrait;

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
