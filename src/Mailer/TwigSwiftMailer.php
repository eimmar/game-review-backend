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


namespace App\Mailer;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TwigSwiftMailer extends \FOS\UserBundle\Mailer\TwigSwiftMailer
{
    private string $frontendUrl;

    /**
     * TwigSwiftMailer constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param UrlGeneratorInterface $router
     * @param \Twig_Environment $twig
     * @param ParameterBagInterface $params
     * @param string $frontendUrl
     */
    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $router, \Twig_Environment $twig, ParameterBagInterface $params, string $frontendUrl)
    {
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
    }

    /**
     * {@inheritdoc}
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['template']['resetting'];
        $url = $this->frontendUrl . '/reset-password/' . $user->getConfirmationToken();
        $context = [
            'user' => $user,
            'confirmationUrl' => $url,
        ];

        $this->sendMessage($template, $context, $this->parameters['from_email']['resetting'], (string) $user->getEmail());
    }
}