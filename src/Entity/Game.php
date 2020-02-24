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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $mainImagePath;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $developer;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $publisher;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $ageRating;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Screenshot", mappedBy="game", orphanRemoval=true)
//     */
//    private $screenShots;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Genre", mappedBy="game", orphanRemoval=true)
//     */
//    private $genres;

//    /**
//     * @Assert\NotBlank
//     * @ORM\OneToMany(targetEntity="App\Entity\Platform", mappedBy="game", orphanRemoval=true)
//     */
//    private $platforms;

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
