<?php

namespace App\Entity;

use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private Game $game;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="10000")
     * @ORM\Column(type="string", length=10000)
     */
    private string $comment;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @var string|null
     * @Assert\Length(max="1000")
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private ?string $pros;

    /**
     * @var string|null
     * @Assert\Length(max="1000")
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private ?string $cons;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Range(min="1", max="10")
     * @ORM\Column(type="integer")
     */
    private int $rating;
}
