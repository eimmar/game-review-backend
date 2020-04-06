<?php


namespace App\Controller;

use App\Form\UserType;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/api/auth")
 */
class AuthController extends BaseApiController
{
    /**
     * @Route("/login", name="login_options", methods={"OPTIONS"})
     * @Route("/register", name="register_options", methods={"OPTIONS"})
     * @Route("/forgot-password", name="forgot_password_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @return JsonResponse|RedirectResponse
     */
    public function register(Request $request, UserManagerInterface $userManager)
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
                $userManager->updateUser($user);
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }

            return $this->apiResponseBuilder->buildMessageResponse($user->getUsername(). " has been registered!");
        }
        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

//    /**
//     * @Route("/forgot-password", name="forgot_password", methods={"POST"})
//     * @param Request $request
//     * @param UserManagerInterface $userManager
//     * @return JsonResponse|RedirectResponse
//     */
//    public function forgotPassword(Request $request, UserManagerInterface $userManager)
//    {
//        $username = $request->request->get('username');
//
//        /** @var $user UserInterface */
//        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
//
//        /** @var $dispatcher EventDispatcherInterface */
//        $dispatcher = $this->get('event_dispatcher');
//
//        /* Dispatch init event */
//        $event = new GetResponseNullableUserEvent($user, $request);
//        $dispatcher->dispatch($event);
//
//        if (null !== $event->getResponse()) {
//            return $event->getResponse();
//        }
//
//        if (null === $user) {
//            return new JsonResponse(
//                'User not recognised',
//                JsonResponse::HTTP_FORBIDDEN
//            );
//        }
//
//        $event = new GetResponseUserEvent($user, $request);
//        $dispatcher->dispatch($event);
//
//        if (null !== $event->getResponse()) {
//            return $event->getResponse();
//        }
//
//        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
//            return new JsonResponse(
//                $this->get('translator')->trans('resetting.password_already_requested', [], 'FOSUserBundle'),
//                JsonResponse::HTTP_FORBIDDEN
//            );
//        }
//
//        if (null === $user->getConfirmationToken()) {
//            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
//            $tokenGenerator = $this->get('fos_user.util.token_generator');
//            $user->setConfirmationToken($tokenGenerator->generateToken());
//        }
//
//        /* Dispatch confirm event */
//        $event = new GetResponseUserEvent($user, $request);
//        $dispatcher->dispatch($event);
//
//        if (null !== $event->getResponse()) {
//            return $event->getResponse();
//        }
//
//        $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
//        $user->setPasswordRequestedAt(new \DateTime());
//        $this->get('fos_user.user_manager')->updateUser($user);
//
//        /* Dispatch completed event */
//        $event = new GetResponseUserEvent($user, $request);
//        $dispatcher->dispatch($event);
//
//        if (null !== $event->getResponse()) {
//            return $event->getResponse();
//        }
//
//        return new JsonResponse(
//            $this->get('translator')->trans(
//                'resetting.check_email',
//                [ '%tokenLifetime%' => floor($this->container->getParameter('fos_user.resetting.token_ttl') / 3600) ],
//                'FOSUserBundle'
//            ),
//            JsonResponse::HTTP_OK
//        );
//    }

    /**
     * @Route("/forgot-password", name="forgot_password", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $user = $this->get('fos_user.user_manager')->findUserByEmail($request->query->get('email'));
        if (null === $user) {
            return $this->apiResponseBuilder->buildMessageResponse($this->createNotFoundException()->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->apiResponseBuilder->buildMessageResponse('Password request alerady requested', Response::HTTP_BAD_REQUEST);
        }

        if (null === $user->getConfirmationToken()) {
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
