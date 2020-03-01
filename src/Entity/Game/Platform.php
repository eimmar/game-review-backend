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
class Platform
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $abbreviation;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

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
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="platforms")
     */
    private $games;
}
