<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use App\Service\ApiJsonResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/vehicle")
 */
class VehicleController extends AbstractController
{
    /**
     * @Route("/", name="vehicle_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function options(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/{id}", name="individual_vehicle_options", methods={"OPTIONS"})
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function individualOptions(ApiJsonResponseBuilder $builder): JsonResponse
    {
        return $builder->preflightResponse();
    }

    /**
     * @Route("/", name="vehicle_index", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function index(ApiJsonResponseBuilder $builder, VehicleRepository $vehicleRepository): JsonResponse
    {
        return $builder->buildResponse($vehicleRepository->findAll());
    }

    /**
     * @Route("/", name="vehicle_new", methods={"POST"})
     * @param Request $request
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function new(Request $request, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($vehicle);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="vehicle_show", methods={"GET"})
     * @param ApiJsonResponseBuilder $builder
     * @param Vehicle $vehicle
     * @return JsonResponse
     */
    public function show(ApiJsonResponseBuilder $builder, Vehicle $vehicle): JsonResponse
    {
        return $builder->buildResponse($vehicle);
    }

    /**
     * @Route("/{id}", name="vehicle_edit", methods={"PUT"})
     * @param Request $request
     * @param Vehicle $vehicle
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function edit(Request $request, Vehicle $vehicle, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $builder->buildResponse('Incorrect data.', 400);
            }
            return $builder->buildResponse($vehicle);
        }

        return $builder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="vehicle_delete", methods={"DELETE"})
     * @param Vehicle $vehicle
     * @param ApiJsonResponseBuilder $builder
     * @return JsonResponse
     */
    public function delete(Vehicle $vehicle, ApiJsonResponseBuilder $builder): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vehicle);
        $entityManager->flush();

        return $builder->buildResponse($vehicle);
    }
}
