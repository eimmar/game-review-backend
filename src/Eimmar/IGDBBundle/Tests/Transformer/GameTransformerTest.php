<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Tests\Transformer;


use App\Eimmar\IGDBBundle\DTO\AgeRating;
use App\Eimmar\IGDBBundle\DTO\Company;
use App\Eimmar\IGDBBundle\DTO\Game;
use App\Eimmar\IGDBBundle\DTO\Platform;
use App\Eimmar\IGDBBundle\Service\Transformer\AgeRating\ContentDescriptionTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\AgeRatingTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\CompanyTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\EntityTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\CoverTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\GameModeTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\GenreTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\InvolvedCompanyTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\ScreenshotTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\ThemeTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\Game\WebsiteTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\GameTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\PlatformTransformer;
use App\Eimmar\IGDBBundle\Service\Transformer\TimeToBeatTransformer;
use PHPUnit\Framework\TestCase;

class GameTransformerTest extends TestCase
{

    private GameTransformer $transformer;

    public function setUp()
    {
        $ageRatingTransformer = new AgeRatingTransformer(new ContentDescriptionTransformer());
        $entityTransformer =  new EntityTransformer();
        $gameModeTransformer = new GameModeTransformer();
        $genreTransformer = new GenreTransformer();
        $involvedCompanyTransformer = new InvolvedCompanyTransformer(new CompanyTransformer($entityTransformer, new \App\Eimmar\IGDBBundle\Service\Transformer\Company\WebsiteTransformer()));
        $platformTransformer = new PlatformTransformer($entityTransformer);
        $screenshotTransformer = new ScreenshotTransformer();
        $themeTransformer = new ThemeTransformer();
        $websiteTransformer = new WebsiteTransformer();
        $timeToBeatTransformer = new TimeToBeatTransformer();
        $coverTransformer = new CoverTransformer();

        $this->transformer = new GameTransformer(
            $ageRatingTransformer,
            $entityTransformer,
            $gameModeTransformer,
            $genreTransformer,
            $involvedCompanyTransformer,
            $platformTransformer,
            $screenshotTransformer,
            $themeTransformer,
            $websiteTransformer,
            $timeToBeatTransformer,
            $coverTransformer,
        );
    }

    public function testTransform()
    {
        $response = json_decode(file_get_contents(__DIR__ . '/../Data/games.json'))[0];

        $ageRatings = [
            $ageRating1 = new AgeRating(
                12782,
                1,
                [
                    new AgeRating\ContentDescription(3, 1, 'Blood'),
                    new AgeRating\ContentDescription(10, 1, 'Intense Violence')
                ],
                11,
                null,
                null
            ),
            $ageRating2 = new AgeRating(12783, 2, [50], 4, null, 'synopsis'),
        ];

        $gameMode = new Game\GameMode(1, 'Single player', 'single-player', 'url', 1298937600, 1323216000);
        $genre = new Game\Genre(31, 'Adventure', 'adventure', 'url2', 1323561600,1323561600);
        $involvedCompany = new Game\InvolvedCompany(
            75640,
            new Company(907, 1459468800, null, null, null, null, null, null, [], null, [], null, null, null, null, null),
            false,
            41876,
            false,
            true,
            false,
            1552694400,
            1552780800
        );
        $platform = new Platform(48, 'PS4', 'PS4', 1, 8, 231, 1, 'ps4', [17], [11], 'PlayStation 4', 'ps4Url', 'ps4--1', 1433116800, 1326499200);
        $screenshot = new Game\Screenshot(108770, null, null, 1075, 'ikajnzvqtohdnhiwigve', 'imageUrl', 2048);
        $theme = new Game\Theme(1, 'Action', 'action', 'actionUrl', 1322524800, 1323216000);
        $cover = new Game\Cover(85167, 41876, false, false, 800, 'co1tpr', 'coverUrl', 600);

        $expected = new Game(
            41876,
            $ageRatings,
            null,
            null,
            [21055],
            [],
            [10962],
            0,
            97,
            [],
            [],
            [],
            1481846400,
            null,
            null,
            [],
            [],
            [$gameMode],
            [$genre],
            null,
            [$involvedCompany],
            [],
            [],
            [$platform],
            [2],
            2.337346481468469,
            1,
            93.4710882069384,
            27,
            [89795],
            [$screenshot],
            [37419, 78632, 86521, 87622, 96217, 103292, 105049, 106987, 111130, 115785],
            [],
            null,
            null,
            'summmary',
            [1, 268435487],
            [$theme],
            93.4710882069384,
            27,
            'Remastered',
            [],
            [],
            'Uncharted 3',
            'gameUrl',
            'uncharted-3',
            1587254400,
            1498953600,
            512,
            null,
            null,
            $cover,
        );

        $this->assertEquals($expected, $this->transformer->transform($response));
    }
}
