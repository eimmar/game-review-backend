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

namespace App\Tests\Unit\EventListener;

use App\EventListener\JWTNotFoundEventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundEventListenerTest extends TestCase
{
    private JWTNotFoundEventListener $listener;

    public function setUp()
    {
        $this->listener = new JWTNotFoundEventListener(['url', 'url2']);
    }

    public function testOnJWTNotFound()
    {
        $event = new JWTNotFoundEvent();
        $event->setResponse(new Response());

        $this->listener->onJWTNotFound($event);
        $this->assertEquals('url,url2', $event->getResponse()->headers->get('Access-Control-Allow-Origin'));
    }
}
