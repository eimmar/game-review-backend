<?php

declare(strict_types=1);

namespace App\EventListener;


use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

class JWTFailureEventListener
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
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', implode(',', $this->corsAllowedUrls));
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', implode(',', $this->corsAllowedUrls));
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', implode(',', $this->corsAllowedUrls));
    }
}
