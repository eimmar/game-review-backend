<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Traits;

trait TimestampableTrait
{
    /**
     * @var int|null
     */
    protected ?int $createdAt;

    /**
     * @var int|null
     */
    protected ?int $updatedAt;

    /**
     * @return int|null
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @return int|null
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }
}
