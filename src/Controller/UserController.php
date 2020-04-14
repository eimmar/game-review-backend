<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\ForgotPasswordRequest;
use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
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
     * @Route("/{id}", name="user_show_options", methods={"OPTIONS"})
     * @Route("/{id}/change-password", name="change_password_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="user_index", methods={"POST"})
     * @param UserRepository $userRepository
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function index(UserRepository $userRepository, SearchRequest $request): JsonResponse
    {
        $users = $userRepository->filter($request);

        return $this->apiResponseBuilder->buildPaginationResponse(
            new PaginationResponse(1, $userRepository->countWithFilter($request), $request->getPageSize(), $users),
            ['groups' => ['user']]
        );
    }
    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($user, 200, [], ['groups' => ['user']]);
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
        $form = $this->createForm(ChangePasswordType::class, new ForgotPasswordRequest());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            /** @var ForgotPasswordRequest $request */
            $request = $form->getData();
            $user->setPlainPassword($request->getEmail());
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
