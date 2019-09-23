<?php


namespace App\Security\Http\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationFailureHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class CORSAuthenticationFailureHandler extends AuthenticationFailureHandler
{
    /**
     * @var array
     */
    private $corsAllowedUrls;

    public function __construct(EventDispatcherInterface $dispatcher, array $corsAllowedUrls)
    {
        parent::__construct($dispatcher);
        $this->corsAllowedUrls = $corsAllowedUrls;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = parent::onAuthenticationFailure($request, $exception);
        $response->headers->set('Access-Control-Allow-Origin', implode(', ', $this->corsAllowedUrls));
        return $response;
    }
}