<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $madeFrom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $madeTo;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $fuelType;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $engineCapacity;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $power;

    /**
     * @Assert\NotBlank
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="vehicle", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @var float|null
     */
    private $rating;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getMadeFrom(): ?int
    {
        return $this->madeFrom;
    }

    public function setMadeFrom(int $madeFrom): self
    {
        $this->madeFrom = $madeFrom;

        return $this;
    }

    public function getMadeTo(): ?int
    {
        return $this->madeTo;
    }

    public function setMadeTo(?int $madeTo): self
    {
        $this->madeTo = $madeTo;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getEngineCapacity(): ?int
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(int $engineCapacity): self
    {
        $this->engineCapacity = $engineCapacity;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
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

    /**
     * @return float|int
     */
    public function getRating()
    {
        if ($this->rating === null && $this->getReviews()->count()) {
            $avg = 0;
            foreach ($this->getReviews() as $review) {
                $avg += $review->getRating();
            }
            $this->rating = $avg / $this->getReviews()->count();
        }

        return $this->rating;
    }
}
