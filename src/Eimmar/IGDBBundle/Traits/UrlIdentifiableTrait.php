<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Traits;

trait UrlIdentifiableTrait
{
    /**
     * @var string|null
     */
    protected ?string $name;

    /**
     * @var string|null
     */
    protected ?string $slug;

    /**
     * @var string|null
     */
    protected ?string $url;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
}
