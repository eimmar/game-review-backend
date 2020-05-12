<?php

declare(strict_types=1);

namespace App\Service\Transformer\IGDB;

use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;

class GameWebsiteTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Website[]
     */
    private array $gameWebsiteCache;

    /**
     * @param Game\Screenshot[] $items
     */
    public function setCache($items)
    {
        $this->gameWebsiteCache = $items;
    }

    /**
     * @param IGDB\Game\Website $igdbWebsite
     * @return Game\Website
     */
    public function transform($igdbWebsite)
    {
        if (isset($this->gameWebsiteCache[$igdbWebsite->getId()])) {
            $website = $this->gameWebsiteCache[$igdbWebsite->getId()];
        } else {
            $website = new Game\Website();
        }

        $website->setUrl($igdbWebsite->getUrl());
        $website->setExternalId($igdbWebsite->getId());
        $website->setCategory($igdbWebsite->getCategory());
        $website->setTrusted($igdbWebsite->getTrusted());

        return $website;
    }
}
