<?php


namespace App\Security\Http\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class CORSAuthenticationSuccessHandler extends AuthenticationSuccessHandler
{
    /**
     * @var array
     */
    private $corsAllowedUrls;

    public function __construct(JWTTokenManagerInterface $jwtManager, EventDispatcherInterface $dispatcher, array $corsAllowedUrls)
    {
        parent::__construct($jwtManager, $dispatcher);
        $this->corsAllowedUrls = $corsAllowedUrls;
    }

    /**
     * @param UserInterface $user
     * @param null $jwt
     * @return JWTAuthenticationSuccessResponse
     */
    public function handleAuthenticationSuccess(UserInterface $user, $jwt = null)
    {
        $response =  parent::handleAuthenticationSuccess($user, $jwt);
        $response->headers->set('Access-Control-Allow-Origin', implode(', ', $this->corsAllowedUrls));
        return $response;
    }
}