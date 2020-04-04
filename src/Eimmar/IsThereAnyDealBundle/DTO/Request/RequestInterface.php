<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\DTO\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function unwrap(): array;

    public function getCacheKey(): string;
}
