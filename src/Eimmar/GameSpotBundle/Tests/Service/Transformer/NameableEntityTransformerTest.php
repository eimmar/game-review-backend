<?php

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
