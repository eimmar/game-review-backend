<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Tests\ParamConverter;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\SearchRequest;
use App\Eimmar\IsThereAnyDealBundle\ParamConverter\SearchRequestConverter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SearchRequestConverterTest extends TestCase
{
    private SearchRequestConverter $service;

    public function setUp()
    {
        $this->service = new SearchRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],file_get_contents(__DIR__ . '/../Data/search.json'));
        $configuration = new ParamConverter(['name' => 'request', 'class' => SearchRequest::class]);
        $expected = new SearchRequest('Game', 0, null, 'eu2', 'lt', ['steam', 'shop']);

        $this->service->apply($request, $configuration);

        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"limit":10,"offset":0,"sort":"publish_date:desc"}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => SearchRequest::class]);

        $this->expectException(InvalidArgumentException::class);

        $this->service->apply($request, $configuration);
    }
}
