<?php

declare(strict_types=1);

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
