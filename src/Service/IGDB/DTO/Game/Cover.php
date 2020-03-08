<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\ImageTrait;
use App\Traits\IdentifiableTrait;

class Cover
{
    use ImageTrait;
    use IdentifiableTrait;

    /**
     * @var Game|int|null
     */
    private $game;

    /**
     * @param int $id
     * @param Game|int|null $game
     * @param bool|null $alphaChannel
     * @param bool|null $animated
     * @param int|null $height
     * @param string|null $imageId
     * @param string|null $url
     * @param int|null $width
     */
    public function __construct(
        int $id,
        $game,
        ?bool $alphaChannel,
        ?bool $animated,
        ?int $height,
        ?string $imageId,
        ?string $url,
        ?int $width
    ) {
        $this->id = $id;
        $this->alphaChannel = $alphaChannel;
        $this->animated = $animated;
        $this->height = $height;
        $this->imageId = $imageId;
        $this->url = $url;
        $this->width = $width;
        $this->game = $game;
    }

    /**
     * @return Game|int|null
     */
    public function getGame()
    {
        return $this->game;
    }
}
