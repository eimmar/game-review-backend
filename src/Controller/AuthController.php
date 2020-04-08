<?php


namespace App\Controller;

use App\DTO\ForgotPasswordRequest;
use App\Form\UserType;
use App\Service\ApiJsonResponseBuilder;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/auth")
 */
class AuthController extends BaseApiController
{
    private UserManagerInterface $userManager;

    private FactoryInterface $resettingFormFactory;

    /**
     * @param UserManagerInterface $userManager
     * @param ApiJsonResponseBuilder $builder
     * @param FactoryInterface $resettingFormFactory
     */
    public function __construct(UserManagerInterface $userManager, ApiJsonResponseBuilder $builder, FactoryInterface $resettingFormFactory)
    {
        parent::__construct($builder);

        $this->userManager = $userManager;
        $this->resettingFormFactory = $resettingFormFactory;
    }

    /**
     * @Route("/login", name="login_options", methods={"OPTIONS"})
     * @Route("/register", name="register_options", methods={"OPTIONS"})
     * @Route("/forgot-password", name="forgot_password_options", methods={"OPTIONS"})
     * @Route("/reset-password/{token}", name="reset_password_options", methods={"OPTIONS"})
     * @Route("/reset-password-check/{token}", name="reset_password_check_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $plainPass = $user->getPassword();
            $user
                ->setPlainPassword($plainPass)
                ->setEnabled(true)
                ->setRoles(['ROLE_USER'])
                ->setSuperAdmin(false);
            try {
                $this->userManager->updateUser($user);
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }

            return $this->apiResponseBuilder->buildMessageResponse($user->getUsername(). " has been registered!");
        }
        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/forgot-password", name="forgot_password", methods={"POST"})
     * @param ForgotPasswordRequest $request
     * @param UserManagerInterface $userManager
     * @param MailerInterface $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param ParameterBagInterface $params
     * @return JsonResponse
     * @throws \Exception
     */
    public function forgotPassword(
        ForgotPasswordRequest $request,
        \App\Mailer\TwigSwiftMailer $mailer,
        TokenGeneratorInterface $tokenGenerator,
        ParameterBagInterface $params
    ) {
        $user = $this->userManager->findUserByEmail($request->getEmail());
        if ($user === null) {
            return $this->apiResponseBuilder->buildMessageResponse('', Response::HTTP_OK);
        }

        if ($user->isPasswordRequestNonExpired($params->get('fos_user.resetting.token_ttl'))) {
            return $this->apiResponseBuilder->buildMessageResponse('Password change already requested', Response::HTTP_BAD_REQUEST);
        }

        if ($user->getConfirmationToken() === null) {
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $mailer->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->userManager->updateUser($user);

        return $this->apiResponseBuilder->buildMessageResponse('', Response::HTTP_OK);
    }

    /**
     * @Route("/reset-password-check/{token}", name="reset_password_check", methods={"POST"})
     * @param string $token
     * @param ParameterBagInterface $params
     * @return JsonResponse
     */
    public function resetPasswordCheck($token, ParameterBagInterface $params)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if ($user && $user->isPasswordRequestNonExpired($params->get('fos_user.resetting.token_ttl'))) {
            return $this->apiResponseBuilder->buildMessageResponse('', Response::HTTP_OK);
        }

        return $this->apiResponseBuilder->buildMessageResponse('Bad Request', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/reset-password/{token}", name="fos_user_resetting_reset", methods={"POST"})
     * @param Request $request
     * @param string $token
     * @param EventDispatcherInterface $eventDispatcher
     * @return JsonResponse
     */
    public function resetAction(Request $request, string $token, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return $this->apiResponseBuilder->buildMessageResponse('User not found', Response::HTTP_BAD_REQUEST);
        }

        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if ($event->getResponse() !== null) {
            return $event->getResponse();
        }

        $form = $this->resettingFormFactory->createForm();
        $form->setData($user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);
            $this->userManager->updateUser($user);

            return $this->apiResponseBuilder->buildMessageResponse('', Response::HTTP_OK);
        }

        return $this->apiResponseBuilder->buildMessageResponse('Bad Request', Response::HTTP_BAD_REQUEST);
    }
}
