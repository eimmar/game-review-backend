<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer\Review;

use App\Eimmar\GameSpotBundle\DTO\Review\Release;
use App\Eimmar\GameSpotBundle\Service\Transformer\Review\ReleaseTransformer;
use PHPUnit\Framework\TestCase;

class ReleaseTransformerTest extends TestCase
{
    private ReleaseTransformer $transformer;

    public function setUp()
    {
        $this->transformer = new ReleaseTransformer();
    }

    public function testTransform()
    {
        $response = [
            'upc' => 'upc',
            'distribution_type' => 'distribution',
            "id" => 1,
            "name" => "Review",
            "region" => "detail",
            "platform" => "site",
            "api_detail_url" => "detailUrl",
        ];
        $expected = new Release('upc','distribution',1, 'Review', 'detail', 'site', 'detailUrl');

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
