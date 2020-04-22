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
        $createdAt = new \DateTimeImmutable();
        $user = $this->createMock(User::class);
        $request = $this->createMock(Request::class);

        $user->method('getId')->willReturn('guid');
        $user->method('getFirstName')->willReturn('firstName');
        $user->method('getLastName')->willReturn('lastName');
        $user->method('getCreatedAt')->willReturn($createdAt);
        $request->method('getContentType')->willReturn('json');
        $request->method('getContent')->willReturn('{}');

        $expected = ['id' => 'guid', 'firstName' => 'firstName', 'lastName' => 'lastName', 'createdAt' => $createdAt];
        $event = new JWTCreatedEvent([], $user);
        $this->requestStack->push($request);

        $this->listener->onJWTCreated($event);
        $this->assertEquals($expected, $event->getData());

    }

    public function testOnJWTCreatedWithRememberMe()
    {
        $createdAt = new \DateTimeImmutable();
        $user = $this->createMock(User::class);
        $request = $this->createMock(Request::class);

        $user->method('getId')->willReturn('guid');
        $user->method('getFirstName')->willReturn('firstName');
        $user->method('getLastName')->willReturn('lastName');
        $user->method('getCreatedAt')->willReturn($createdAt);
        $request->method('getContentType')->willReturn('json');
        $request->method('getContent')->willReturn('{"rememberMe": true}');

        $expected = ['rememberMe' => true, 'id' => 'guid', 'firstName' => 'firstName', 'lastName' => 'lastName', 'createdAt' => $createdAt, 'exp' => (new \DateTime('+' . $this->rememberMeDuration . ' seconds'))->getTimestamp()];
        $event = new JWTCreatedEvent(['rememberMe' => true], $user);
        $this->requestStack->push($request);

        $this->listener->onJWTCreated($event);
        $this->assertEquals($expected, $event->getData());
    }
}
