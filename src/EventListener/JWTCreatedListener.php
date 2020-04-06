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
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    private int $rememberMeDuration;

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     * @param int $rememberMeDuration
     */
    public function __construct(RequestStack $requestStack, int $rememberMeDuration)
    {
        $this->requestStack = $requestStack;
        $this->rememberMeDuration = $rememberMeDuration;
    }

    /**
     * @param JWTCreatedEvent $event
     * @throws \Exception
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request->getContentType() === 'json') {
            $data = json_decode($request->getContent(), true);
            $payload = $event->getData();
            $user = $event->getUser();

            if (isset($data['rememberMe']) && $data['rememberMe']) {
                $expiration = new \DateTime('+' . $this->rememberMeDuration . ' seconds');
                $payload['exp'] = $expiration->getTimestamp();
            }

            $payload['id'] = $user->getId();
            $payload['firstName'] = $user->getFirstName();
            $payload['lastName'] = $user->getLastName();
            $payload['email'] = $user->getEmail();
            unset($payload['username']);

            $event->setData($payload);
        }
    }
}
