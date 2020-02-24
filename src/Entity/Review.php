<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Review
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min="1", max="5")
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ReviewReport", mappedBy="review", orphanRemoval=true)
     */
    private $reviewReports;

    public function __construct()
    {
        $this->reviewReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): ?Game
    {
        return $this->vehicle;
    }

    public function setVehicle(?Game $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return Collection|ReviewReport[]
     */
    public function getReviewReports(): Collection
    {
        return $this->reviewReports;
    }

    public function addReviewReport(ReviewReport $reviewReport): self
    {
        if (!$this->reviewReports->contains($reviewReport)) {
            $this->reviewReports[] = $reviewReport;
            $reviewReport->setReview($this);
        }

        return $this;
    }

    public function removeReviewReport(ReviewReport $reviewReport): self
    {
        if ($this->reviewReports->contains($reviewReport)) {
            $this->reviewReports->removeElement($reviewReport);
            // set the owning side to null (unless already changed)
            if ($reviewReport->getReview() === $this) {
                $reviewReport->setReview(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setDateCreated(new \DateTime());
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => $this->getId(),
            'vehicle' => $this->getVehicle()->serialize(),
            'comment' => $this->getComment(),
            'rating' => $this->getRating(),
            'dateCreated' => $this->getDateCreated(),
            'reviewReports' => $this->getReviewReports()->map(function (ReviewReport $rr) {
                return $rr->serialize();
            })
        ];
    }
}
