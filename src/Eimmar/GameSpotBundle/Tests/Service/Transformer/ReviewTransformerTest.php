<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Image;
use App\Eimmar\GameSpotBundle\DTO\Review;
use App\Eimmar\GameSpotBundle\Service\Transformer\ImageTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\GameReviewTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\ReleaseTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ReviewTransformer;
use PHPUnit\Framework\TestCase;

class ReviewTransformerTest extends TestCase
{
    /**
     * @var ImageTransformer
     */
    private ImageTransformer $imageTransformer;

    /**
     * @var GameReviewTransformer
     */
    private GameReviewTransformer $gameReviewTransformer;

    /**
     * @var ReleaseTransformer
     */
    private ReleaseTransformer $releaseTransformer;

    private ReviewTransformer $transformer;

    public function setUp()
    {
        $this->imageTransformer = $this->createMock(ImageTransformer::class);
        $this->gameReviewTransformer = $this->createMock(GameReviewTransformer::class);
        $this->releaseTransformer = $this->createMock(ReleaseTransformer::class);

        $this->transformer = new ReviewTransformer($this->imageTransformer, $this->gameReviewTransformer, $this->releaseTransformer);
    }

    public function testTransform()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../TestData/review-response.json'), true)['results'][0];
        $image = new Image('', '', '', '');
        $expected = new Review(
            '2012-08-31 06:26:23',
            null,
            null,
            6394451,
            'Eric Neigher',
            'Counter-Strike: Global Offensive Review',
            $image,
            '8.5',
            'Counter-Strike: Global Offensive is a solid update to a classic shooter.',
            'The intense, skill-based combat of Counter-Strike is as enthralling as ever|Low price|New modes put a clever spin on classic Counter-Strike.',
            '',
            null,
            null,
            null,
            [],
            null,
        );

        $this->imageTransformer->expects($this->once())->method('transform')->with($response['image'])->willReturn($image);
        $this->gameReviewTransformer->expects($this->never())->method('transform');
        $this->releaseTransformer->expects($this->never())->method('transform');

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
