<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Game;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Screenshot
{
    use TimestampableTrait;

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
    private $imageId;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $height;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    private $width;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="screenshots")
     */
    private $game;
}
