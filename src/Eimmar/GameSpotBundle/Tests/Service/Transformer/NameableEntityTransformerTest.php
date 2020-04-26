<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\NameableEntity;
use App\Eimmar\GameSpotBundle\Service\Transformer\NameableEntityTransformer;
use PHPUnit\Framework\TestCase;

class NameableEntityTransformerTest extends TestCase
{
    private NameableEntityTransformer $transformer;

    public function setUp()
    {
        $this->transformer = new NameableEntityTransformer();
    }

    public function testTransform()
    {
        $response = ["name" => "Action"];
        $expected = new NameableEntity('Action');

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
