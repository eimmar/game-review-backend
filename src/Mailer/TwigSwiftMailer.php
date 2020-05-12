<?php

declare(strict_types=1);

namespace App\Mailer;

use FOS\UserBundle\Model\UserInterface;
use Swift_Mailer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class TwigSwiftMailer extends \FOS\UserBundle\Mailer\TwigSwiftMailer
{
    private string $frontendUrl;

    protected TranslatorInterface $translator;

    /**
     * @param Swift_Mailer $mailer
     * @param UrlGeneratorInterface $router
     * @param Environment $twig
     * @param ParameterBagInterface $params
     * @param TranslatorInterface $translator
     * @param string $frontendUrl
     * @noinspection PhpParamsInspection
     */
    public function __construct(
        Swift_Mailer $mailer,
        UrlGeneratorInterface $router,
        Environment $twig,
        ParameterBagInterface $params,
        TranslatorInterface $translator,
        string $frontendUrl
    ) {
        parent::__construct($mailer, $router, $twig, [
            'template' => [
                'confirmation' => $params->get('fos_user.registration.confirmation.template'),
                'resetting' => $params->get('fos_user.resetting.email.template'),
            ],
            'from_email' => [
                'confirmation' => $params->get('fos_user.registration.confirmation.from_email'),
                'resetting' => $params->get('fos_user.resetting.email.from_email'),
            ]
        ]);
        $this->frontendUrl = $frontendUrl;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['resetting'];
        $url = $this->frontendUrl . $this->translator->trans('user.action.reset_password.frontend_route') . $user->getConfirmationToken();
        $context = [
            'user' => $user,
            'confirmationUrl' => $url,
        ];

        $this->sendMessage($template, $context, $this->parameters['from_email']['resetting'], (string) $user->getEmail());
    }
}
