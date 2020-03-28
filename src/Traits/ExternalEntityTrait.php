<?php

declare(strict_types=1);

namespace App\Traits;

trait ExternalEntityTrait
{
    /**
     * @var integer
     * @ORM\Column(type="integer", unique=true)
     */
    protected int $externalId;

    /**
     * @return int
     */
    public function getExternalId(): int
    {
        return $this->externalId;
    }

    /**
     * @param int $externalId
     */
    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }
}
