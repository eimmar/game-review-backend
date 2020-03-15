<?php

namespace App\Entity;

use App\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class GameList
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
     * @var Game[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="gameLists")
     */
    private $games;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private $privacyType;

    /**
     * @var int
     * @Assert\NotBlank
     * @ORM\Column(type="integer", nullable=false)
     */
    private $type;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="gameLists", nullable=false)
     *
     */
    private $user;

    /**
     * @param Game $game
     */
    public function addGame(Game $game)
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
        }
    }

    /**
     * @param Game $game
     */
    public function removeGame(Game $game)
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
        }
    }
}
