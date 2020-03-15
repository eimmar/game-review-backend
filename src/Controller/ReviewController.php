<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Game;
use App\Form\ReviewType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review")
 */
class ReviewController extends BaseApiController
{
    /**
     * @Route("/{id}", name="individual_review_options", methods={"OPTIONS"})
     * @Route("/game/{game}", name="game_review_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/game/{game}", name="reviews_by_game", methods={"GET"})
     * @param Game $game
     * @return JsonResponse
     */
    public function showByGame(Game $game): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($game->getReviews());
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

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($review);
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
     * @Route("/{id}", name="review_edit", methods={"PUT"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @param Review $review
     * @return JsonResponse
     */
    public function edit(Request $request, Review $review): JsonResponse
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($review);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="review_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
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
