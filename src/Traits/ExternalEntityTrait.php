<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\Serializer\Annotation\Groups;

trait ExternalEntityTrait
{
    /**
     * @var integer
     * @Groups({"gameLoaded", "game"})
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
