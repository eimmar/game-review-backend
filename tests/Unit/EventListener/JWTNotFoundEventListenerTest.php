<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\EventListener\JWTFailureEventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundEventListenerTest extends TestCase
{
    private JWTFailureEventListener $listener;

    public function setUp()
    {
        $this->listener = new JWTFailureEventListener(['url', 'url2']);
    }

    public function testOnJWTNotFound()
    {
        $event = new JWTNotFoundEvent();
        $event->setResponse(new Response());

        $this->listener->onJWTNotFound($event);
        $this->assertEquals('url,url2', $event->getResponse()->headers->get('Access-Control-Allow-Origin'));
    }
}
