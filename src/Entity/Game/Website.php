<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Game;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Website
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
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $trusted;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $category;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="websites")
     */
    private $game;
}
