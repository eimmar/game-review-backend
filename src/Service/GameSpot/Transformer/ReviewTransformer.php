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


namespace App\Service\GameSpot\Transformer;

use App\Service\GameSpot\DTO\Review;
use App\Service\GameSpot\Transformer\Review\GameReviewTransformer;
use App\Service\GameSpot\Transformer\Review\ReleaseTransformer;

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
    public function transform(\stdClass $response): Review
    {
        return new Review(
            $this->getProperty($response, 'publish_date'),
            $this->getProperty($response, 'update_date'),
            $this->getProperty($response, 'review_type'),
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'authors'),
            $this->getProperty($response, 'title'),
            $this->imageTransformer->transform($this->getProperty($response, 'image')),
            $this->getProperty($response, 'score'),
            $this->getProperty($response, 'deck'),
            $this->getProperty($response, 'good'),
            $this->getProperty($response, 'bad'),
            $this->getProperty($response, 'body'),
            $this->getProperty($response, 'lede'),
            $this->gameTransformer->transform($this->getProperty($response, 'game')),
            array_map([$this->releaseTransformer, 'transform'], $this->getProperty($response, 'releases')),
            $this->getProperty($response, 'site_detail_url'),
        );
    }
}
