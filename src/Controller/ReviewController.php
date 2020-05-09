<?php

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\PaginationResponse;
use App\Entity\Review;
use App\Entity\Game;
use App\Entity\User;
use App\Enum\LogicExceptionCode;
use App\Exception\LogicException;
use App\Form\ReviewEditType;
use App\Form\ReviewType;
use App\Security\Voter\ReviewVoter;
use App\Service\ApiJsonResponseBuilder;
use App\Service\ReviewService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/review")
 */
class ReviewController extends BaseApiController
{
    private ReviewService $service;

    public function __construct(ApiJsonResponseBuilder $builder, ReviewService $service)
    {
        parent::__construct($builder);
        $this->service = $service;
    }

    /**
     * @Route("/", name="new_review_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_review_options", methods={"OPTIONS"})
     * @Route("/edit/{id}", name="review_edit_options", methods={"OPTIONS"})
     * @Route("/game/{game}", name="game_review_options", methods={"OPTIONS"})
     * @Route("/user/{user}", name="reviews_by_user_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/game/{game}", name="reviews_by_game", methods={"POST"})
     * @param Game $game
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function showByGame(Game $game, PaginationRequest $request): JsonResponse
    {
        $reviews = $this->service->getGameReviews($request, $game);

        return $this->apiResponseBuilder->respondWithPagination(
            new PaginationResponse(1, $this->service->countGameReviews($game), $request->getPageSize(), $reviews),
            ['groups' => ['review', 'user', 'game']]
        );
    }

    /**
     * @Route("/user/{user}", name="reviews_by_user", methods={"POST"})
     * @param PaginationRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function showByUser(PaginationRequest $request, User $user): JsonResponse
    {
        $reviews = $this->service->getUserReviews($request, $user);

        return $this->apiResponseBuilder->respondWithPagination(
            new PaginationResponse($request->getPage(), $this->service->countUserReviews($user), $request->getPageSize(), $reviews),
            ['groups' => ['review', 'user', 'game']]
        );
    }

    /**
     * @Route("/new", name="review_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     * @throws LogicException
     */
    public function new(Request $request): JsonResponse
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->submit(json_decode($request->getContent(), true));
        $this->denyAccessUnlessGranted(ReviewVoter::MODIFY, $review);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->apiResponseBuilder->respond($review, 200, [], ['groups' => ['review', 'user', 'game']]);
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }

    /**
     * @Route("/edit/{id}", name="review_edit", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @param Review $review
     * @return JsonResponse
     * @throws LogicException
     */
    public function edit(Request $request, Review $review): JsonResponse
    {
        $form = $this->createForm(ReviewEditType::class, $review);
        $form->submit(json_decode($request->getContent(), true));
        $this->denyAccessUnlessGranted(ReviewVoter::MODIFY, $review);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->apiResponseBuilder->respond($review, 200, [], ['groups' => ['review', 'user', 'game']]);
        }

        throw new LogicException(LogicExceptionCode::INVALID_DATA);
    }

    /**
     * @Route("/{id}", name="review_show", methods={"GET"})
     * @param Review $review
     * @return JsonResponse
     */
    public function show(Review $review): JsonResponse
    {
        $this->denyAccessUnlessGranted(ReviewVoter::VIEW, $review);

        return $this->apiResponseBuilder->respond($review, 200, [], ['groups' => ['review', 'user', 'game']]);
    }

    /**
     * @Route("/{id}", name="review_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_USER"})
     * @param Review $review
     * @return JsonResponse
     */
    public function delete(Review $review): JsonResponse
    {
        $this->denyAccessUnlessGranted(ReviewVoter::MODIFY, $review);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($review);
        $entityManager->flush();

        return $this->apiResponseBuilder->respond('OK');
    }
}
