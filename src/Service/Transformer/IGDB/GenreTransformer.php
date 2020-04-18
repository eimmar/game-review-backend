<?php

declare(strict_types=1);

namespace App\Service\Transformer\IGDB;

use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class GenreTransformer implements IGDBTransformerInterface
{
    /**
     * @var Game\Genre[]
     */
    private array $genreCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Game\Genre $igdbGenre
     * @return Game\Genre
     */
    public function transform($igdbGenre)
    {
        if (isset($this->genreCache[$igdbGenre->getId()])) {
            $genre = $this->genreCache[$igdbGenre->getId()];
        } else {
            $genre = $this->entityManager->getRepository(Game\Genre::class)->findOneBy(['externalId' => $igdbGenre->getId()]) ?: new Game\Genre();
            $genre->setExternalId($igdbGenre->getId());
            $genre->setName($igdbGenre->getName());
            $genre->setUrl($igdbGenre->getUrl());
            $genre->setSlug($igdbGenre->getSlug() ?? (string)$igdbGenre->getId());

            $this->genreCache[$igdbGenre->getId()] = $genre;
        }

        return $genre;
    }
}
