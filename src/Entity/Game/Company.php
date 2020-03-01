<?php

declare(strict_types=1);




namespace App\Entity\Game;

use App\Entity\Company\CompanyWebsite;
use App\Entity\Game;
use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Company
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
    private $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var CompanyWebsite[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Company\CompanyWebsite", mappedBy="company", orphanRemoval=true)
     */
    private $websites;

    /**
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="companies")
     */
    private $games;
}
