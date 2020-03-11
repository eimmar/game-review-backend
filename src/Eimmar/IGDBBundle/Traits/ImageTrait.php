<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Eimmar\IGDBBundle\Traits;

trait ImageTrait
{
    /**
     * @var bool|null
     */
    protected ?bool $alphaChannel;

    /**
     * @var bool|null
     */
    protected ?bool $animated;

    /**
     * @var int|null
     */
    protected ?int $height;

    /**
     * @var string|null
     */
    protected ?string $imageId;

    /**
     * @var string|null
     */
    protected ?string $url;

    /**
     * @var int|null
     */
    protected ?int $width;

    /**
     * @return bool|null
     */
    public function getAlphaChannel(): ?bool
    {
        return $this->alphaChannel;
    }

    /**
     * @return bool|null
     */
    public function getAnimated(): ?bool
    {
        return $this->animated;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return string|null
     */
    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }
}
