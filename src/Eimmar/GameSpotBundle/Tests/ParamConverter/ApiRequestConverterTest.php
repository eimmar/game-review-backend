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

namespace App\Eimmar\GameSpotBundle\Tests\ParamConverter;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use App\Eimmar\GameSpotBundle\ParamConverter\ApiRequestConverter;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ApiRequestConverterTest extends TestCase
{
    private ApiRequestConverter $service;

    public function setUp()
    {
        $this->service = new ApiRequestConverter();
    }

    public function testApply()
    {
        $request = new Request([],[],[],[],[],[],'{"format":"json","limit":10,"offset":0,"sort":"publish_date:desc"}');
        $configuration = new ParamConverter(['name' => 'apiRequest', 'class' => ApiRequest::class]);
        $expected = new ApiRequest('json', null, null, 10, 0, 'publish_date:desc');

        $this->service->apply($request, $configuration);

        $this->assertEquals($expected, $request->attributes->get($configuration->getName()));
    }

    public function testApplyShouldFailWithIncorrectRequest()
    {
        $request = new Request([],[],[],[],[],[],'{"limit":10,"offset":0,"sort":"publish_date:desc"}');
        $configuration = new ParamConverter(['name' => 'apiRequest', 'class' => ApiRequest::class]);

        $this->expectException(\InvalidArgumentException::class);

        $this->service->apply($request, $configuration);
    }
}
