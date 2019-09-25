<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Vehicle;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
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
     * @Route("/", name="review_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_review_options", methods={"OPTIONS"})
     * @Route("/vehicle/{vehicle}", name="vehicle_review_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="review_index", methods={"GET"})
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     */
    public function index(ReviewRepository $reviewRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($reviewRepository->findAllForApi());
    }

    /**
     * @Route("/vehicle/{vehicle}", name="reviews_by_vehicle", methods={"GET"})
     */
    public function showByVehicle(Vehicle $vehicle): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($vehicle->getReviews());
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
