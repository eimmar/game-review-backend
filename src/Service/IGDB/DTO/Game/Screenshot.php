<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO\Game;

use App\Service\IGDB\DTO\ResponseDTO;
use App\Service\IGDB\Traits\ImageTrait;
use App\Traits\IdentifiableTrait;

class Screenshot implements ResponseDTO
{
    use ImageTrait;
    use IdentifiableTrait;

    /**
     * @param int $id
     * @param bool|null $alphaChannel
     * @param bool|null $animated
     * @param int|null $height
     * @param string|null $imageId
     * @param string|null $url
     * @param int|null $width
     */
    public function __construct(
        int $id,
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
    }
}
