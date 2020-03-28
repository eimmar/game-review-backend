<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\DTO;

class NameableEntity implements DTO
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
