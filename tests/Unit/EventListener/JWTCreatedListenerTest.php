<?php

declare(strict_types=1);

namespace App\Tests\Unit\EventListener;

use App\Entity\User;
use App\EventListener\JWTCreatedListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListenerTest extends TestCase
{
    private JWTCreatedListener $listener;

    private RequestStack $requestStack;

    private int $rememberMeDuration = 2629743;

    public function setUp()
    {
        $this->requestStack = new RequestStack();
        $this->listener = new JWTCreatedListener($this->requestStack, $this->rememberMeDuration);
    }

    public function testOnJWTCreated()
    {
        $user = $this->createMock(User::class);
        $request = $this->createMock(Request::class);

        $user->method('getId')->willReturn('guid');
        $request->method('getContentType')->willReturn('json');
        $request->method('getContent')->willReturn('{}');

        $event = new JWTCreatedEvent([], $user);
        $this->requestStack->push($request);

        $this->listener->onJWTCreated($event);
        $this->assertFalse(isset($event->getData()['rememberMe']));

    }

    public function testOnJWTCreatedWithRememberMe()
    {
        $user = $this->createMock(User::class);
        $request = $this->createMock(Request::class);

        $user->method('getId')->willReturn('guid');
        $request->method('getContentType')->willReturn('json');
        $request->method('getContent')->willReturn('{"rememberMe": true}');

        $event = new JWTCreatedEvent(['rememberMe' => true], $user);
        $this->requestStack->push($request);

        $this->listener->onJWTCreated($event);
        $this->assertTrue(isset($event->getData()['rememberMe']));
    }
}
