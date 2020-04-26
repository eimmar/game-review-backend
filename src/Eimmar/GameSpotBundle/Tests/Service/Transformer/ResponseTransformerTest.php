<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\DTO\Review;
use App\Eimmar\GameSpotBundle\Service\Transformer\ResponseTransformer;
use App\Eimmar\GameSpotBundle\Service\Transformer\ReviewTransformer;
use PHPUnit\Framework\TestCase;

class ResponseTransformerTest extends TestCase
{
    private ResponseTransformer $transformer;

    public function setUp()
    {
        $this->transformer = new ResponseTransformer();
    }

    public function testTransformWithResultsTransformer()
    {
        $reviewTransformer = $this->createMock(ReviewTransformer::class);
        $response = json_decode(file_get_contents(__DIR__ . '/../TestData/review-response.json'), true);
        $review = new Review('', '', '', 0, '', '', null, '','', '', '', '', '', null, null, '');
        $results = [$review];
        $expected = new Response(
            $response['error'],
            $response['limit'],
            $response['offset'],
            $response['number_of_page_results'],
            $response['number_of_total_results'],
            $response['status_code'],
            $results,
            $response['version'],
        );

        $reviewTransformer->expects($this->once())->method('transform')->willReturn($review);

        $this->assertEquals($expected, $this->transformer->transform($response, $reviewTransformer));
    }

    public function testTransformWithoutResultsTransformer()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../TestData/review-response.json'), true);
        $results = [
            [
                'publishDate' => '2012-08-31 06:26:23',
                'id' => 6394451,
                'authors' => 'Eric Neigher',
                'title' => 'Counter-Strike: Global Offensive Review',
                'image' =>
                    [
                        'squareTiny' => 'https://gamespot1.cbsistatic.com/uploads/square_tiny/mig/1/0/2/0/2121020-169_counter_strike_offensive_video_review_multi_083112_m1.jpg',
                        'screenTiny' => 'https://gamespot1.cbsistatic.com/uploads/screen_tiny/mig/1/0/2/0/2121020-169_counter_strike_offensive_video_review_multi_083112_m1.jpg',
                        'squareSmall' => 'https://gamespot1.cbsistatic.com/uploads/square_small/mig/1/0/2/0/2121020-169_counter_strike_offensive_video_review_multi_083112_m1.jpg',
                        'original' => 'https://gamespot1.cbsistatic.com/uploads/original/mig/1/0/2/0/2121020-169_counter_strike_offensive_video_review_multi_083112_m1.jpg',
                    ],
                'score' => 8.5,
                'deck' => 'Counter-Strike: Global Offensive is a solid update to a classic shooter.',
                'good' => 'The intense, skill-based combat of Counter-Strike is as enthralling as ever|Low price|New modes put a clever spin on classic Counter-Strike.',
                'bad' => '',
            ]
        ];

        $expected = new Response(
            $response['error'],
            $response['limit'],
            $response['offset'],
            $response['number_of_page_results'],
            $response['number_of_total_results'],
            $response['status_code'],
            $results,
            $response['version'],
        );

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
