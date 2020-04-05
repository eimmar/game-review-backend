<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Review;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\GameReviewTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\ReleaseTransformer;

class ReviewTransformer extends AbstractDTOTransformer
{
    /**
     * @var ImageTransformer
     */
    private ImageTransformer $imageTransformer;

    /**
     * @var GameReviewTransformer
     */
    private GameReviewTransformer $gameTransformer;

    /**
     * @var ReleaseTransformer
     */
    private ReleaseTransformer $releaseTransformer;

    /**
     * ReviewTransformer constructor.
     * @param ImageTransformer $imageTransformer
     * @param GameReviewTransformer $gameTransformer
     * @param ReleaseTransformer $releaseTransformer
     */
    public function __construct(
        ImageTransformer $imageTransformer,
        GameReviewTransformer $gameTransformer,
        ReleaseTransformer $releaseTransformer
    ) {
        $this->imageTransformer = $imageTransformer;
        $this->gameTransformer = $gameTransformer;
        $this->releaseTransformer = $releaseTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform(array $response): Review
    {
        $image = $this->getProperty($response, 'image');
        $game = $this->getProperty($response, 'game');

        return new Review(
            $this->getProperty($response, 'publish_date'),
            $this->getProperty($response, 'update_date'),
            $this->getProperty($response, 'review_type'),
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'authors'),
            $this->getProperty($response, 'title'),
            $image ? $this->imageTransformer->transform($image) : null,
            $this->getProperty($response, 'score'),
            $this->getProperty($response, 'deck'),
            $this->getProperty($response, 'good'),
            $this->getProperty($response, 'bad'),
            $this->getProperty($response, 'body'),
            $this->getProperty($response, 'lede'),
            $game ? $this->gameTransformer->transform($game) : null,
            array_map([$this->releaseTransformer, 'transform'], (array)$this->getProperty($response, 'releases')),
            $this->getProperty($response, 'site_detail_url'),
        );
    }
}
