<?php

namespace App\Entity;

use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Review
{
    use TimestampableTrait;

    /**
     * @var string
     * @Groups({"review"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @Groups({"review"})
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @Groups({"review"})
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Groups({"review"})
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="10000")
     * @ORM\Column(type="string", length=10000)
     */
    private string $comment;

    /**
     * @Groups({"review"})
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @Groups({"review"})
     * @var string|null
     * @Assert\Length(max="1000")
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private ?string $pros;

    /**
     * @Groups({"review"})
     * @var string|null
     * @Assert\Length(max="1000")
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private ?string $cons;

    /**
     * @Groups({"review"})
     * @var int
     * @Assert\NotBlank
     * @Assert\Range(min="1", max="10")
     * @ORM\Column(type="integer")
     */
    private int $rating;

    /**
     * @Groups({"review"})
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $approved;

    /**
     * Review constructor.
     */
    public function __construct()
    {
        $this->comment = '';
        $this->title = '';
        $this->pros = null;
        $this->cons = null;
        $this->approved = false;
        $this->rating = 0;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getPros(): ?string
    {
        return $this->pros;
    }

    /**
     * @param string|null $pros
     */
    public function setPros(?string $pros): void
    {
        $this->pros = $pros;
    }

    /**
     * @return string|null
     */
    public function getCons(): ?string
    {
        return $this->cons;
    }

    /**
     * @param string|null $cons
     */
    public function setCons(?string $cons): void
    {
        $this->cons = $cons;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     */
    public function setApproved(bool $approved): void
    {
        $this->approved = $approved;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
