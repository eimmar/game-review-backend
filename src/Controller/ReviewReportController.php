<?php

namespace App\Controller;

use App\Entity\ReviewReport;
use App\Form\ReviewReportType;
use App\Repository\ReviewReportRepository;
use App\Service\ApiJsonResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review-report")
 */
class ReviewReportController extends AbstractController
{
    /**
     * @Route("/", name="reviewReport_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function options(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/{id}", name="individual_reviewReport_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function individualOptions(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/", name="reviewReport_index", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param ReviewReportRepository $reviewReportRepository
     * @return JsonResponse
     */
    public function index(ApiJsonResponseBuilder $builder, ReviewReportRepository $reviewReportRepository): JsonResponse
    {
        return $builder->buildResponse($reviewReportRepository->findAll());
    }

    /**
     * @Route("/", name="reviewReport_new", methods={"POST"})
     * @param Request $request
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function new(Request $request, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $reviewReport = new ReviewReport();
        $form = $this->createForm(ReviewReportType::class, $reviewReport);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reviewReport);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($reviewReport);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="reviewReport_show", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param ReviewReport $reviewReport
     * @return JsonResponse
     */
    public function show(ApiJsonResponseBuilder $builder, ReviewReport $reviewReport): JsonResponse
    {
        return $builder->buildResponse($reviewReport);
    }

    /**
     * @Route("/{id}", name="reviewReport_edit", methods={"PUT"})
     * @param Request $request
     * @param ReviewReport $reviewReport
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function edit(Request $request, ReviewReport $reviewReport, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $form = $this->createForm(ReviewReportType::class, $reviewReport);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($reviewReport);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="reviewReport_delete", methods={"DELETE"})
     * @param ReviewReport $reviewReport
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function delete(ReviewReport $reviewReport, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reviewReport);
        $entityManager->flush();

        return $builder->buildResponse($reviewReport);
    }
}
