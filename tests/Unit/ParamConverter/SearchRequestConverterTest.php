<?php

declare(strict_types=1);

namespace App\Tests\Unit\ParamConverter;

use App\DTO\SearchRequest;
use App\ParamConverter\SearchRequestConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class SearchRequestConverterTest extends TestCase
{
    private SearchRequestConverter $converter;

    public function setUp()
    {
        $this->converter = new SearchRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],'{"pageSize":21,"page":1,"firstResult":0,"orderBy":"releaseDate","order":"asc","filters":{"platform":"playstation-5"}}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => SearchRequest::class]);
        $expected = new SearchRequest(1, 21, ['platform' => 'playstation-5'], 'releaseDate', 'asc', 0);

        $this->converter->apply($request, $configuration);
        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"page":1,"orderBy":"releaseDate","order":"asc","filters":{"platform":"playstation-5"}}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => SearchRequest::class]);

        $this->expectException(\InvalidArgumentException::class);
        $this->converter->apply($request, $configuration);
    }
}
