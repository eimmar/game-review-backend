<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Transformer;

use App\DTO\SearchRequest;
use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Service\Transformer\SearchRequestToIGDBRequestTransformer;
use PHPUnit\Framework\TestCase;

class SearchRequestToIGDBRequestTransformerTest extends TestCase
{
    private SearchRequestToIGDBRequestTransformer $transformer;

    public function setUp()
    {
        $this->transformer = new SearchRequestToIGDBRequestTransformer();
    }

    public function testTransformSlugArrayField()
    {
        $reflector = new \ReflectionClass($this->transformer);
        $method = $reflector->getMethod('transformSlugArrayField');
        $method->setAccessible(true);

        $data = [];
        $request = new SearchRequest(0, 0, ['name' => 'game', 'rating' => ['big', 'large'], 'category' => null]);

        $method->invokeArgs($this->transformer, [&$data, $request, 'name']);
        $method->invokeArgs($this->transformer, [&$data, $request, 'rating']);
        $method->invokeArgs($this->transformer, [&$data, $request, 'category']);
        $method->invokeArgs($this->transformer, [&$data, $request, 'random']);

        $this->assertEquals(['name' => '= ("game")', 'total_rating' => '= ("big", "large")'], $data);
    }

    public function testTransform()
    {
        $searchRequest = new SearchRequest(
            1,
            21,
            [
                'query' => 'game',
                'releaseDateFrom' => '2020-04-01',
                'releaseDateTo' => '2020-04-30',
                'category' => '0',
                'ratingFrom' => '80',
                'ratingTo' => '82',
                'genre' => 'shooter',
                'theme' => 'horror',
                'platform' => ['win', 'linux'],
                'gameMode' => 'single-player',
            ],
            'rating',
            'desc',
            0
        );

        $expected = new RequestBody(
            [],
            [
                'genres.slug' => '= ("shooter")',
                'themes.slug' => '= ("horror")',
                'platforms.slug' => '= ("win", "linux")',
                'game_modes.slug' => '= ("single-player")',
                'total_rating' => '>= 80 & total_rating <= 82 & total_rating != null',
                'first_release_date' => '>= 1585688400 & first_release_date <= 1588194000',
                'total_rating_count' => '>= 20',
            ],
            '',
            'game',
            21,
            0
        );

        $this->assertEquals($expected, $this->transformer->transform($searchRequest));
    }
}
