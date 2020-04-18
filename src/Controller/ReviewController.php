<?php

namespace App\Controller;

use App\DTO\PaginationRequest;
use App\DTO\PaginationResponse;
use App\Entity\Review;
use App\Entity\Game;
use App\Entity\User;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\Criteria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/review")
 */
class ReviewController extends BaseApiController
{
    /**
     * @Route("/", name="new_review_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_review_options", methods={"OPTIONS"})
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
     * @param ReviewRepository $repository
     * @param Game $game
     * @param PaginationRequest $request
     * @return JsonResponse
     */
    public function showByGame(ReviewRepository $repository, Game $game, PaginationRequest $request): JsonResponse
    {
        $reviews = $repository->findBy(
            ['game' => $game, 'approved' => true],
            ['createdAt' => 'DESC'],
            $request->getPageSize(),
            $request->getFirstResult()
        );

        return $this->apiResponseBuilder->buildPaginationResponse(
            new PaginationResponse(1, $repository->count(['game' => $game]), $request->getPageSize(), $reviews),
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
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('approved', true))
            ->orderBy(['createdAt' => 'DESC'])
            ->setFirstResult($request->getFirstResult())
            ->setMaxResults($request->getPageSize());
        $reviews = $user->getReviews()->matching($criteria)->toArray();

        return $this->apiResponseBuilder->buildPaginationResponse(
            new PaginationResponse($request->getPage(), $user->getReviews()->count(), $request->getPageSize(), $reviews),
            ['groups' => ['review', 'user', 'game']]
        );
    }

    /**
     * @Route("/", name="review_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($review, 200, [], ['groups' => ['review', 'user', 'game']]);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="review_show", methods={"GET"})
     * @param Review $review
     * @return JsonResponse
     */
    public function show(Review $review): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($review);
    }

    /**
     * @Route("/{id}", name="review_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Review $review
     * @return JsonResponse
     */
    public function delete(Review $review): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($review);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($review);
    }
}
