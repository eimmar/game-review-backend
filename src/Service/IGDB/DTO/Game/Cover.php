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
     * @param Game|int|null $game
     * @param bool|null $alphaChannel
     * @param bool|null $animated
     * @param int|null $height
     * @param string|null $imageId
     * @param string|null $url
     * @param int|null $width
     */
    public function __construct(
        $game,
        ?bool $alphaChannel,
        ?bool $animated,
        ?int $height,
        ?string $imageId,
        ?string $url,
        ?int $width
    ) {
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
