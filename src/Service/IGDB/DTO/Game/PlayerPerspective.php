<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;

class PlayerPerspective
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;

    /**
     * @param string|null $name
     * @param string|null $slug
     * @param string|null $url
     * @param int|null $createdAt
     * @param int|null $updatedAt
     */
    public function __construct(?string $name, ?string $slug, ?string $url, ?int $createdAt, ?int $updatedAt)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->url = $url;
        $this->updatedAt = $updatedAt;
        $this->createdAt = $createdAt;
    }
}
