<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer\Review;

use App\Eimmar\GameSpotBundle\DTO\Review\GameReview;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\GameReviewTransformer;
use PHPUnit\Framework\TestCase;

class GameReviewTransformerTest extends TestCase
{
    private GameReviewTransformer $transformer;

    public function setUp()
    {
        $this->transformer = new GameReviewTransformer();
    }

    public function testTransform()
    {
        $response = ["id" => 1, "name" => "Review", "api_detail_url" => "detail", "site_detail_url" => "site"];
        $expected = new GameReview(1, 'Review', 'detail', 'site');

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
