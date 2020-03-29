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


namespace App\Service\Transformer\IGDB;

use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;

class ScreenshotTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Screenshot[]
     */
    private array $screenshotCache;

    /**
     * @param Game\Screenshot[] $items
     */
    public function setCache($items)
    {
        $this->screenshotCache = $items;
    }

    /**
     * @param IGDB\Game\Screenshot $igdbScreenshot
     * @return Game\Screenshot
     */
    public function transform($igdbScreenshot)
    {
        if (isset($this->screenshotCache[$igdbScreenshot->getId()])) {
            $screenshot = $this->screenshotCache[$igdbScreenshot->getId()];
        } else {
            $screenshot = new Game\Screenshot();
            $screenshot->setUrl($igdbScreenshot->getUrl());
            $screenshot->setExternalId($igdbScreenshot->getId());
            $screenshot->setHeight($igdbScreenshot->getHeight());
            $screenshot->setWidth($igdbScreenshot->getWidth());
            $screenshot->setImageId($igdbScreenshot->getImageId());
        }

        return $screenshot;
    }
}
