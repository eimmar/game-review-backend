<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Game;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class GameMode
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="gameModes")
     */
    private $games;
}
