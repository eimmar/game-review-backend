<?php


namespace App\Controller;

use App\Form\UserType;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/auth")
 */
class AuthController extends BaseApiController
{
    /**
     * @Route("/login", name="login_options", methods={"OPTIONS"})
     * @Route("/register", name="register_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/register", name="api_auth_register",  methods={"POST"})
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
                $userManager->updateUser($user, true);
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildResponse('Incorrect data.', 400);
            }

            return $this->apiResponseBuilder->buildResponse($user->getUsername(). " has been registered!");
        }
        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }
}
