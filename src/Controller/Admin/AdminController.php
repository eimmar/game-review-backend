<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Mailer\TwigSwiftMailer;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/actions")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/reset-password-request/{user}", name="admin_password_reset_for_user", methods={"GET"})
     * @param User $user
     * @param TwigSwiftMailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param TranslatorInterface $translator
     * @param UserManagerInterface $userManager
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPasswordRequest(
        User $user,
        TwigSwiftMailer $mailer,
        TokenGeneratorInterface $tokenGenerator,
        TranslatorInterface $translator,
        UserManagerInterface $userManager,
        Request $request
    ) {
        if ($user->getConfirmationToken() === null) {
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $mailer->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $userManager->updateUser($user);

        $this->addFlash('sonata_flash_success', $translator->trans('user.action.reset_password.success'));

        return $this->redirect($request->headers->get('referer'));
    }
}
