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


namespace App\Entity\Game;

use App\Entity\Game;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="ageRatings")
     */
    private $games;
}
