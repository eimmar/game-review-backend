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
    private $id;

    /**
     * @var Game
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Range(min="1", max="100")
     * @ORM\Column(type="integer")
     */
    private $rating;
}
