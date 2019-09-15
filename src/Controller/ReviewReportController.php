<?php

namespace App\Controller;

use App\Entity\ReviewReport;
use App\Form\ReviewReportType;
use App\Repository\ReviewReportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/review/report")
 */
class ReviewReportController extends AbstractController
{
    /**
     * @Route("/", name="review_report_index", methods={"GET"})
     */
    public function index(ReviewReportRepository $reviewReportRepository): Response
    {
        return $this->render('review_report/index.html.twig', [
            'review_reports' => $reviewReportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="review_report_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reviewReport = new ReviewReport();
        $form = $this->createForm(ReviewReportType::class, $reviewReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reviewReport);
            $entityManager->flush();

            return $this->redirectToRoute('review_report_index');
        }

        return $this->render('review_report/new.html.twig', [
            'review_report' => $reviewReport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="review_report_show", methods={"GET"})
     */
    public function show(ReviewReport $reviewReport): Response
    {
        return $this->render('review_report/show.html.twig', [
            'review_report' => $reviewReport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="review_report_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReviewReport $reviewReport): Response
    {
        $form = $this->createForm(ReviewReportType::class, $reviewReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_report_index');
        }

        return $this->render('review_report/edit.html.twig', [
            'review_report' => $reviewReport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="review_report_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReviewReport $reviewReport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reviewReport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reviewReport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('review_report_index');
    }
}
