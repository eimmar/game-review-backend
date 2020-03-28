<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\DTO\AgeRating;

use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class ContentDescription implements ResponseDTO
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @param int $id
     * @param int|null $category
     * @param string|null $description
     */
    public function __construct(int $id, ?int $category, ?string $description)
    {
        $this->id = $id;
        $this->category = $category;
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
