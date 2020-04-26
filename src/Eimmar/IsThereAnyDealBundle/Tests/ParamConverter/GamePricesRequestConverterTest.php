<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Tests\ParamConverter;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use App\Eimmar\IsThereAnyDealBundle\ParamConverter\GamePricesRequestConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class GamePricesRequestConverterTest extends TestCase
{
    private GamePricesRequestConverter $service;

    public function setUp()
    {
        $this->service = new GamePricesRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],file_get_contents(__DIR__ . '/../Data/game-prices.json'));
        $configuration = new ParamConverter(['name' => 'request', 'class' => GamePricesRequest::class]);
        $expected = new GamePricesRequest(['plain1', 'plain2'], 'eu2', 'lt', null, ['exclude'], 0);

        $this->service->apply($request, $configuration);

        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"limit":10,"offset":0,"sort":"publish_date:desc"}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => GamePricesRequest::class]);

        $this->expectException(\InvalidArgumentException::class);

        $this->service->apply($request, $configuration);
    }
}
