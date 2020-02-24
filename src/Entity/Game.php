<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $externalId;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $storyline;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=true)
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", length=255, nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\AgeRating", mappedBy="game", orphanRemoval=true)
//     */
//    private $ageRatings;

    //    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Genre", mappedBy="game", orphanRemoval=true)
//     */
//    private $genres;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Screenshot", mappedBy="game", orphanRemoval=true)
//     */
//    private $screenshots;

    //    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Genre", mappedBy="game", orphanRemoval=true)
//     */
//    private $themes;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Platform", mappedBy="game", orphanRemoval=true)
//     */
//    private $platforms;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\AggregatedRating", mappedBy="game", orphanRemoval=true)
//     */
//    private $aggregatedRatings;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\GameMode", mappedBy="game", orphanRemoval=true)
//     */
//    private $gameModes;

//    /**
//     * @Assert\NotBlank
//     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="game", orphanRemoval=true)
//     */
//    private $similarGames;

//    /**
//     * @Assert\NotBlank
//     * @ORM\ManyToMany(targetEntity="App\Entity\TimeToBeat", mappedBy="game", orphanRemoval=true)
//     */
//    private $timesToBeat;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\GameWebsite", mappedBy="game", orphanRemoval=true)
//     */
//    private $websites;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\GameCompany", mappedBy="game", orphanRemoval=true)
//     */
//    private $involvedCompanies;

    /**
     * @Assert\NotBlank
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="vehicle", orphanRemoval=true)
     */
    private $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setVehicle($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getVehicle() === $this) {
                $review->setVehicle(null);
            }
        }

        return $this;
    }

    public function serialize()
    {
        return [
            "id" => $this->getId(),
        ];
    }
}
