<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use App\Service\ApiJsonResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review")
 */
class ReviewController extends AbstractController
{
    /**
     * @Route("/", name="review_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function options(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/{id}", name="individual_review_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function individualOptions(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/", name="review_index", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     */
    public function index(ApiJsonResponseBuilder $builder, ReviewRepository $reviewRepository): JsonResponse
    {
        return $builder->buildResponse($reviewRepository->findAll());
    }

    /**
     * @Route("/", name="review_new", methods={"POST"})
     * @param Request $request
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function new(Request $request, ApiJsonResponseBuilder $builder): JsonResponse
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
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($review);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="review_show", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param Review $review
     * @return JsonResponse
     */
    public function show(ApiJsonResponseBuilder $builder, Review $review): JsonResponse
    {
        return $builder->buildResponse($review);
    }

    /**
     * @Route("/{id}", name="review_edit", methods={"PUT"})
     * @param Request $request
     * @param Review $review
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function edit(Request $request, Review $review, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $form = $this->createForm(ReviewType::class, $review);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($review);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="review_delete", methods={"DELETE"})
     * @param Review $review
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function delete(Review $review, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($review);
        $entityManager->flush();

        return $builder->buildResponse($review);
    }
}
