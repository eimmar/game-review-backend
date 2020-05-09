<?php


namespace App\Controller;

use App\DTO\ForgotPasswordRequest;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Form\UserType;
use App\Mailer\TwigSwiftMailer;
use App\Service\ApiJsonResponseBuilder;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
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
     * @throws LogicException
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
            } catch (UniqueConstraintViolationException $e) {
                throw new LogicException(LogicExceptionCode::AUTH_EMAIL_ALREADY_EXISTS);
            }

            return $this->apiResponseBuilder->respond('OK');
        }
        throw new LogicException(LogicExceptionCode::INVALID_DATA);

    }

    /**
     * @Route("/forgot-password", name="forgot_password", methods={"POST"})
     * @param ForgotPasswordRequest $request
     * @param TwigSwiftMailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param ParameterBagInterface $params
     * @return JsonResponse
     * @throws LogicException
     */
    public function forgotPassword(
        ForgotPasswordRequest $request,
        TwigSwiftMailer $mailer,
        TokenGeneratorInterface $tokenGenerator,
        ParameterBagInterface $params
    ) {
        $user = $this->userManager->findUserByEmail($request->getEmail());
        if ($user === null) {
            throw new LogicException(LogicExceptionCode::INVALID_DATA);
        }

        if ($user->isPasswordRequestNonExpired($params->get('fos_user.resetting.token_ttl'))) {
            throw new LogicException(LogicExceptionCode::AUTH_PASSWORD_CHANGE_ALREADY_REQUESTED);
        }

        if ($user->getConfirmationToken() === null) {
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $mailer->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->userManager->updateUser($user);

        return $this->apiResponseBuilder->respond('OK');
    }

    /**
     * @Route("/reset-password-check/{token}", name="reset_password_check", methods={"POST"})
     * @param string $token
     * @param ParameterBagInterface $params
     * @return JsonResponse
     * @throws LogicException
     */
    public function resetPasswordCheck($token, ParameterBagInterface $params)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if ($user && $user->isPasswordRequestNonExpired($params->get('fos_user.resetting.token_ttl'))) {
            return $this->apiResponseBuilder->respond('OK');
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }

    /**
     * @Route("/reset-password/{token}", name="fos_user_resetting_reset", methods={"POST"})
     * @param Request $request
     * @param string $token
     * @param EventDispatcherInterface $eventDispatcher
     * @return JsonResponse
     * @throws LogicException
     */
    public function reset(Request $request, string $token, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new LogicException(LogicExceptionCode::INVALID_DATA);
        }

        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if ($event->getResponse() !== null) {
            throw new LogicException(LogicExceptionCode::INVALID_DATA);
        }

        $form = $this->resettingFormFactory->createForm();
        $form->setData($user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);
            $this->userManager->updateUser($user);

            return $this->apiResponseBuilder->respond('OK');
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }
}
