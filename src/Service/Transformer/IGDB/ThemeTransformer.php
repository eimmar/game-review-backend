<?php

declare(strict_types=1);

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
