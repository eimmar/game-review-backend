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


namespace App\Service\IGDB\DTO\Company;

use App\Service\IGDB\Traits\ImageTrait;

class CompanyLogo
{
    use ImageTrait;

    /**
     * @param bool|null $alphaChannel
     * @param bool|null $animated
     * @param int|null $height
     * @param string|null $imageId
     * @param string|null $url
     * @param int|null $width
     */
    public function __construct(
        ?bool $alphaChannel,
        ?bool $animated,
        ?int $height,
        ?string $imageId,
        ?string $url,
        ?int $width
    ) {
        $this->alphaChannel = $alphaChannel;
        $this->animated = $animated;
        $this->height = $height;
        $this->imageId = $imageId;
        $this->url = $url;
        $this->width = $width;
    }
}
