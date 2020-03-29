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

use App\Entity\Game\Theme;
use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class ThemeTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Theme[]
     */
    private array $themeCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Game\Theme $igdbTheme
     * @return Theme
     */
    public function transform($igdbTheme): Theme
    {
        if (isset($this->themeCache[$igdbTheme->getId()])) {
            $theme = $this->themeCache[$igdbTheme->getId()];
        } else {
            $theme = $this->entityManager->getRepository(Theme::class)->findOneBy(['externalId' => $igdbTheme->getId()]) ?: new Theme();
            $theme->setExternalId($igdbTheme->getId());
            $theme->setUrl($igdbTheme->getUrl());
            $theme->setName($igdbTheme->getName());

            $this->themeCache[$igdbTheme->getId()] = $theme;
        }

        return $theme;
    }
}
