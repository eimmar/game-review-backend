<?php

namespace App\Controller;

use App\Entity\ReviewReport;
use App\Form\ReviewReportType;
use App\Repository\ReviewReportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review-report")
 */
class ReviewReportController extends BaseApiController
{
    /**
     * @Route("/", name="reviewReport_options", methods={"OPTIONS"})
     * @Route("/{id}", name="individual_reviewReport_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="reviewReport_index", methods={"GET"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param ReviewReportRepository $reviewReportRepository
     * @return JsonResponse
     */
    public function index(ReviewReportRepository $reviewReportRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($reviewReportRepository->findAll());
    }

    /**
     * @Route("/", name="reviewReport_new", methods={"POST"})
     * @IsGranted({"ROLE_USER"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
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
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($reviewReport);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="reviewReport_show", methods={"GET"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param ReviewReport $reviewReport
     * @return JsonResponse
     */
    public function show(ReviewReport $reviewReport): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($reviewReport);
    }

    /**
     * @Route("/{id}", name="reviewReport_edit", methods={"PUT"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @param ReviewReport $reviewReport
     * @return JsonResponse
     */
    public function edit(Request $request, ReviewReport $reviewReport): JsonResponse
    {
        $form = $this->createForm(ReviewReportType::class, $reviewReport);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildMessageResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($reviewReport);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="reviewReport_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     * @param ReviewReport $reviewReport
     * @return JsonResponse
     */
    public function delete(ReviewReport $reviewReport): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reviewReport);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($reviewReport);
    }
}
