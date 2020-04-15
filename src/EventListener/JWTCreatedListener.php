<?php

declare(strict_types=1);

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
            $payload['createdAt'] = $user->getCreatedAt();

            $event->setData($payload);
        }
    }
}
