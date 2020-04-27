<?php

declare(strict_types=1);

namespace App\Tests\Unit\ParamConverter;

use App\DTO\PaginationRequest;
use App\ParamConverter\PaginationRequestConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class PaginationRequestConverterTest extends TestCase
{
    private PaginationRequestConverter $converter;

    public function setUp()
    {
        $this->converter = new PaginationRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],'{"pageSize":21,"page":1,"firstResult":0}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => PaginationRequest::class]);
        $expected = new PaginationRequest(1, 21, 0);

        $this->converter->apply($request, $configuration);
        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"pageSize":21}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => PaginationRequest::class]);

        $this->expectException(\InvalidArgumentException::class);
        $this->converter->apply($request, $configuration);
    }
}
