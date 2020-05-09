<?php

namespace App\Controller;

use App\DTO\PaginationResponse;
use App\DTO\SearchRequest;
use App\Entity\User;
use App\Service\ApiJsonResponseBuilder;
use App\Service\FriendshipService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/friendship")
 */
class FriendshipController extends BaseApiController
{
    private FriendshipService $friendshipService;

    /**
     * @param ApiJsonResponseBuilder $builder
     * @param FriendshipService $friendshipService
     */
    public function __construct(ApiJsonResponseBuilder $builder, FriendshipService $friendshipService)
    {
        parent::__construct($builder);
        $this->friendshipService = $friendshipService;
    }

    /**
     * @Route("/get/{user}", name="get_friendship_options", methods={"OPTIONS"})
     * @Route("/add/{friend}", name="add_friend_options", methods={"OPTIONS"})
     * @Route("/remove/{friend}", name="remove_friend_options", methods={"OPTIONS"})
     * @Route("/accept/{friend}", name="accept_friend_request_options", methods={"OPTIONS"})
     * @Route("/", name="friendships_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/get/{user}", name="get_friendship", methods={"GET"})
     * @param User $user
     * @return JsonResponse
     */
    public function friendshipStatus(User $user): JsonResponse
    {
        $friendship = $this->friendshipService->getFriendship($user);

        return $this->apiResponseBuilder->respond($friendship, 200, [], ['groups' => ['friendship', 'user']]);
    }

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/add/{friend}", name="add_friend", methods={"GET"})
     * @param User $friend
     * @return JsonResponse
     */
    public function addFriend(User $friend): JsonResponse
    {
        $friendship = $this->friendshipService->addFriend($friend);

        return $this->apiResponseBuilder->respond($friendship, 200, [], ['groups' => ['friendship']]);
    }

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/remove/{friend}", name="remove_friend", methods={"GET"})
     * @param User $friend
     * @return JsonResponse
     */
    public function removeFriend(User $friend): JsonResponse
    {
        $this->friendshipService->removeFriendship($friend);

        return $this->apiResponseBuilder->respond('OK');
    }

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/accept/{friend}", name="accept_friend_request", methods={"GET"})
     * @param User $friend
     * @return JsonResponse
     */
    public function acceptFriendRequest(User $friend): JsonResponse
    {
        $friendship = $this->friendshipService->acceptRequest($friend);

        return $this->apiResponseBuilder->respond($friendship, 200, [], ['groups' => ['friendship']]);
    }

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/", name="friendships", methods={"POST"})
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function friendships(SearchRequest $request): JsonResponse
    {
        $friendships = $this->friendshipService->getFriendships($request);
        $total = $this->friendshipService->countFriendships($request);

        return $this->apiResponseBuilder->respondWithPagination(
            new PaginationResponse($request->getPage(), $total, $request->getPageSize(), $friendships),
            ['groups' => ['user', 'friendship']]
        );
    }
}
