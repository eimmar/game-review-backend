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


namespace App\Eimmar\GameSpotBundle\DTO;

use App\Eimmar\GameSpotBundle\DTO\Review\GameReview;
use App\Eimmar\GameSpotBundle\DTO\Review\Release;

class Review implements DTO
{
    /**
     * @var string|null
     */
    private ?string $publishDate;

    /**
     * @var string|null
     */
    private ?string $updateDate;

    /**
     * @var string|null
     */
    private ?string $reviewType;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private ?string $authors;

    /**
     * @var string|null
     */
    private ?string $title;

    /**
     * @var Image|null
     */
    private ?Image $image;

    /**
     * @var string|null
     */
    private ?string $score;

    /**
     * @var string|null
     */
    private ?string $deck;

    /**
     * @var string|null
     */
    private ?string $good;

    /**
     * @var string|null
     */
    private ?string $bad;

    /**
     * @var string|null
     */
    private ?string $body;

    /**
     * @var string|null
     */
    private ?string $lede;

    /**
     * @var GameReview|null
     */
    private ?GameReview $game;

    /**
     * @var Release[]|array|null
     */
    private ?array $releases;

    /**
     * @var string|null
     */
    private ?string $siteDetailUrl;

    /**
     * @param string|null $publishDate
     * @param string|null $updateDate
     * @param string|null $reviewType
     * @param int|null $id
     * @param string|null $authors
     * @param string|null $title
     * @param Image|null $image
     * @param string|null $score
     * @param string|null $deck
     * @param string|null $good
     * @param string|null $bad
     * @param string|null $body
     * @param string|null $lede
     * @param GameReview|null $game
     * @param Release[]|array|null $releases
     * @param string|null $siteDetailUrl
     */
    public function __construct(
        ?string $publishDate,
        ?string $updateDate,
        ?string $reviewType,
        ?int $id,
        ?string $authors,
        ?string $title,
        ?Image $image,
        ?string $score,
        ?string $deck,
        ?string $good,
        ?string $bad,
        ?string $body,
        ?string $lede,
        ?GameReview $game,
        $releases,
        ?string $siteDetailUrl
    ) {
        $this->publishDate = $publishDate;
        $this->updateDate = $updateDate;
        $this->reviewType = $reviewType;
        $this->id = $id;
        $this->authors = $authors;
        $this->title = $title;
        $this->image = $image;
        $this->score = $score;
        $this->deck = $deck;
        $this->good = $good;
        $this->bad = $bad;
        $this->body = $body;
        $this->lede = $lede;
        $this->game = $game;
        $this->releases = $releases;
        $this->siteDetailUrl = $siteDetailUrl;
    }

    /**
     * @return string|null
     */
    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    /**
     * @return string|null
     */
    public function getUpdateDate(): ?string
    {
        return $this->updateDate;
    }

    /**
     * @return string|null
     */
    public function getReviewType(): ?string
    {
        return $this->reviewType;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getScore(): ?string
    {
        return $this->score;
    }

    /**
     * @return string|null
     */
    public function getDeck(): ?string
    {
        return $this->deck;
    }

    /**
     * @return string|null
     */
    public function getGood(): ?string
    {
        return $this->good;
    }

    /**
     * @return string|null
     */
    public function getBad(): ?string
    {
        return $this->bad;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getLede(): ?string
    {
        return $this->lede;
    }

    /**
     * @return GameReview|null
     */
    public function getGame(): ?GameReview
    {
        return $this->game;
    }

    /**
     * @return Release[]|array|null
     */
    public function getReleases()
    {
        return $this->releases;
    }

    /**
     * @return string|null
     */
    public function getSiteDetailUrl(): ?string
    {
        return $this->siteDetailUrl;
    }
}
