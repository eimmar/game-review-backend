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

            $this->genreCache[$igdbGenre->getId()] = $genre;
        }

        return $genre;
    }
}
