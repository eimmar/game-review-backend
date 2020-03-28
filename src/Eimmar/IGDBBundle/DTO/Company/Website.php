<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\DTO\Company;

use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class Website implements ResponseDTO
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var bool|null
     */
    private ?bool $trusted;

    /**
     * @var string|null
     */
    private ?string $url;

    /**
     * @param int $id
     * @param int|null $category
     * @param bool|null $trusted
     * @param string|null $url
     */
    public function __construct(int $id, ?int $category, ?bool $trusted, ?string $url)
    {
        $this->id = $id;
        $this->category = $category;
        $this->trusted = $trusted;
        $this->url = $url;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return bool|null
     */
    public function getTrusted(): ?bool
    {
        return $this->trusted;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
