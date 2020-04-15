<?php

declare(strict_types=1);

namespace App\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

class JWTNotFoundEventListener
{
    /**
     * @var array
     */
    private array $corsAllowedUrls;

    public function __construct(array $corsAllowedUrls)
    {
        $this->corsAllowedUrls = $corsAllowedUrls;
    }

    /**
     * @param JWTCreatedEvent $event
     * @throws \Exception
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', implode(',', $this->corsAllowedUrls));
    }
}
