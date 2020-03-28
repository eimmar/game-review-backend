<?php
//
//declare(strict_types=1);
//
//
//
//
//namespace App\Entity\Game;
//
//use App\Entity\Game;
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * @ORM\Entity
// */
//class AggregatedRating
//{
//    /**
//     * @var string
//     * @ORM\Id()
//     * @ORM\Column(type="guid")
//     * @ORM\GeneratedValue(strategy="UUID")
//     */
//    private string $id;
//
//    /**
//     * @var int
//     * @ORM\Column(type="integer")
//     */
//    private int $count;
//
//    /**
//     * @var float
//     * @ORM\Column(type="float")
//     */
//    private float $rating;
//
//    /**
//     * @var Game
//     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="aggregatedRatings")
//     */
//    private Game $game;
//
//    /**
//     * @return string
//     */
//    public function getId(): string
//    {
//        return $this->id;
//    }
//
//    /**
//     * @param string $id
//     */
//    public function setId(string $id): void
//    {
//        $this->id = $id;
//    }
//
//    /**
//     * @return int
//     */
//    public function getCount(): int
//    {
//        return $this->count;
//    }
//
//    /**
//     * @param int $count
//     */
//    public function setCount(int $count): void
//    {
//        $this->count = $count;
//    }
//
//    /**
//     * @return float
//     */
//    public function getRating(): float
//    {
//        return $this->rating;
//    }
//
//    /**
//     * @param float $rating
//     */
//    public function setRating(float $rating): void
//    {
//        $this->rating = $rating;
//    }
//
//    /**
//     * @return Game
//     */
//    public function getGame(): Game
//    {
//        return $this->game;
//    }
//
//    /**
//     * @param Game $game
//     */
//    public function setGame(Game $game): void
//    {
//        $this->game = $game;
//    }
//}
