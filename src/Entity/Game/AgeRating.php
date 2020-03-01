<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Game;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AgeRating
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $externalId;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $synopsis;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $category;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="ageRatings")
     */
    private $games;
}
