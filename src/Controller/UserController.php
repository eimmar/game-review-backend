<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
use App\Entity\User;
use App\Form\UserEditType;
use App\Repository\UserRepository;
use App\Security\UserVoter;
use App\Service\ApiJsonResponseBuilder;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends BaseApiController
{
    private UserManagerInterface $userManager;

    private FactoryInterface $changePasswordFormFactory;

    /**
     * @param UserManagerInterface $userManager
     * @param ApiJsonResponseBuilder $builder
     * @param FactoryInterface $changePasswordFormFactory
     */
    public function __construct(UserManagerInterface $userManager, ApiJsonResponseBuilder $builder, FactoryInterface $changePasswordFormFactory)
    {
        parent::__construct($builder);

        $this->userManager = $userManager;
        $this->changePasswordFormFactory = $changePasswordFormFactory;
    }

    /**
     * @Route("/", name="user_options", methods={"OPTIONS"})
     * @Route("/{id}", name="user_show_options", methods={"OPTIONS"})
     * @Route("/change-password/{id}", name="user_change_password_options", methods={"OPTIONS"})
     * @Route("/edit/{id}", name="edit_user_options", methods={"OPTIONS"})
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
     * @Route("/change-password/{id}", name="user_change_password", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function changePassword(Request $request, User $user)
    {
        $form = $this->changePasswordFormFactory->createForm();
        $form->setData($user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $this->userManager->updateUser($user);

            return $this->apiResponseBuilder->buildMessageResponse('OK');
        }

        return $this->apiResponseBuilder->buildMessageResponse('Bad Request', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/edit/{id}", name="edit_user", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param User $user
     * @param UserManagerInterface $userManager
     * @return JsonResponse
     */
    public function edit(Request $request, User $user, UserManagerInterface $userManager): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserVoter::EDIT, $user);
        $form = $this->createForm(UserEditType::class, $user);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $userManager->updateUser($user);
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }

            return $this->apiResponseBuilder->buildResponse($user, 200, [], ['groups' => 'user']);
        }
        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }
}
