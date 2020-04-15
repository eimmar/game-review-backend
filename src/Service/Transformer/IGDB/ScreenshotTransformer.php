<?php

declare(strict_types=1);

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
        }

        $screenshot->setUrl($igdbScreenshot->getUrl());
        $screenshot->setExternalId($igdbScreenshot->getId());
        $screenshot->setHeight($igdbScreenshot->getHeight());
        $screenshot->setWidth($igdbScreenshot->getWidth());
        $screenshot->setImageId($igdbScreenshot->getImageId());

        return $screenshot;
    }
}
