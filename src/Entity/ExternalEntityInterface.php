<?php

declare(strict_types=1);

namespace App\Entity;

interface ExternalEntityInterface
{
    public function getExternalId(): int;

    public function setExternalId(int $id);
}
