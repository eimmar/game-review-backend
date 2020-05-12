<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Game;
use App\Eimmar\GameSpotBundle\DTO\Image;
use App\Eimmar\GameSpotBundle\DTO\NameableEntity;
use App\Eimmar\GameSpotBundle\Service\Transformer\GameTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ImageTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\NameableEntityTransformer;
use PHPUnit\Framework\TestCase;

class GameTransformerTest extends TestCase
{
    /**
     * @var ImageTransformer
     */
    private ImageTransformer $imageTransformer;

    /**
     * @var NameableEntityTransformer
     */
    private NameableEntityTransformer $nameableEntityTransformer;

    private GameTransformer $transformer;

    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    public function setUp()
    {
        $this->imageTransformer = $this->createMock(ImageTransformer::class);
        $this->nameableEntityTransformer = $this->createMock(NameableEntityTransformer::class);

        $this->transformer = new GameTransformer($this->imageTransformer, $this->nameableEntityTransformer);
    }

    public function testTransform()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../TestData/game-response.json'), true)['results'][0];
        $image = new Image('', '', '', '');
        $genre1 = new NameableEntity('Action');
        $genre2 = new NameableEntity('Shooter');
        $expected = new Game(
            '2015-12-31 12:00:00',
            'Description',
            125765,
            'Fortnite',
            'Deck',
            $image,
            [$genre1, $genre2],
            [],
            [],
            'images',
            'reviews',
            'articles',
            'videos',
            'releases',
            'detail',
        );

        $this->imageTransformer->expects($this->once())->method('transform')->with($response['image'])->willReturn($image);
        $this->nameableEntityTransformer
            ->expects($this->exactly(2))
            ->method('transform')
            ->withConsecutive([['name' => 'Action']], [['name' => 'Shooter']])
            ->willReturnOnConsecutiveCalls($genre1, $genre2);

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
