<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Traits;

trait IdentifiableTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
