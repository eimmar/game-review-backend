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


namespace App\Controller;

use App\DTO\ChangePasswordRequest;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use App\Security\UserVoter;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends BaseApiController
{
    /**
     * @Route("/", name="user_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_user_options", methods={"OPTIONS"})
     * @Route("/{id}/change-password", name="change_password_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function index(UserRepository $userRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($userRepository->findAll());
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($user);
    }

    /**
     * @Route("/{id}/change-password", name="user_change_password", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param User $user
     * @param UserManagerInterface $userManager
     * @return JsonResponse
     */
    public function changePassword(Request $request, User $user, UserManagerInterface $userManager): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserVoter::CHANGE_PASSWORD, $user);
        $form = $this->createForm(ChangePasswordType::class, new ChangePasswordRequest());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            /** @var ChangePasswordRequest $request */
            $request = $form->getData();
            $user->setPlainPassword($request->getPassword());
            try {
                $userManager->updateUser($user);
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }

            return $this->apiResponseBuilder->buildMessageResponse($user->getUsername(). " has been registered!");
        }
        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }
}
