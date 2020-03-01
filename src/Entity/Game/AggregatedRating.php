<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Game;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AggregatedRating
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $count;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $rating;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="aggregatedRatings")
     */
    private $game;
}
