<?php

declare(strict_types=1);




namespace App\Eimmar\IGDBBundle\DTO\Game;

use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Eimmar\IGDBBundle\Traits\TimestampableTrait;
use App\Eimmar\IGDBBundle\Traits\UrlIdentifiableTrait;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class PlayerPerspective implements ResponseDTO
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
    use IdentifiableTrait;

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $slug
     * @param string|null $url
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(int $id, ?string $name, ?string $slug, ?string $url, ?int $createdAt, ?int $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->url = $url;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }
}
