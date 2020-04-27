<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Transformer;

use App\Service\Transformer\SnakeToCamelCaseTransformer;
use PHPUnit\Framework\TestCase;

class SnakeToCamelCaseTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer =  new SnakeToCamelCaseTransformer();

        $data = [
            "id" => 69359,
            "cover" => [
                "id" => 34231,
                "image_id" => "bbboosegdval1pmsvm9n",
            ],
            "created_at" => 1506470400,
            "external_games" => [
                185946
            ],
        ];

        $expected = [
            "id" => 69359,
            "cover" => [
                "id" => 34231,
                "imageId" => "bbboosegdval1pmsvm9n",
            ],
            "createdAt" => 1506470400,
            "externalGames" => [
                185946
            ],
        ];

        $transformer->transform($data);

        $this->assertEquals($expected, $data);
    }
}
