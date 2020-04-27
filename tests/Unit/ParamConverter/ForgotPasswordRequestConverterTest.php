<?php

declare(strict_types=1);

namespace App\Tests\Unit\ParamConverter;

use App\DTO\ForgotPasswordRequest;
use App\ParamConverter\ForgotPasswordRequestConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordRequestConverterTest extends TestCase
{
    private ForgotPasswordRequestConverter $converter;

    public function setUp()
    {
        $this->converter = new ForgotPasswordRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],'{"email":"test@email.com"}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => ForgotPasswordRequest::class]);
        $expected = new ForgotPasswordRequest('test@email.com');

        $this->converter->apply($request, $configuration);
        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"username":"test@email.com"}');
        $configuration = new ParamConverter(['name' => 'request', 'class' => ForgotPasswordRequest::class]);

        $this->expectException(\InvalidArgumentException::class);
        $this->converter->apply($request, $configuration);
    }
}
