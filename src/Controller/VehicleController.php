<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vehicle")
 */
class VehicleController extends BaseApiController
{
    /**
     * @Route("/", name="vehicle_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function options(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/{id}", name="individual_vehicle_options", methods={"OPTIONS"})
     * @return JsonResponse
     */
    public function individualOptions(): JsonResponse
    {
        return $this->apiResponseBuilder->preflightResponse();
    }

    /**
     * @Route("/", name="vehicle_index", methods={"GET"})
     * @param VehicleRepository $vehicleRepository
     * @return JsonResponse
     */
    public function index(VehicleRepository $vehicleRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($vehicleRepository->findAllWithRatings());
    }

    /**
     * @Route("/", name="vehicle_new", methods={"POST"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
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
                return $this->apiResponseBuilder->buildResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($vehicle);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="vehicle_show", methods={"GET"})
     * @param Vehicle $vehicle
     * @return JsonResponse
     */
    public function show(Vehicle $vehicle): JsonResponse
    {
        $vehicle->getReviews();
        return $this->apiResponseBuilder->buildResponse($vehicle);
    }

    /**
     * @Route("/{id}", name="vehicle_edit", methods={"PUT"})
     * @IsGranted({"ROLE_ADMIN"})
     * @param Request $request
     * @param Vehicle $vehicle
     * @return JsonResponse
     */
    public function edit(Request $request, Vehicle $vehicle): JsonResponse
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                return $this->apiResponseBuilder->buildResponse('Incorrect data.', 400);
            }
            return $this->apiResponseBuilder->buildResponse($vehicle);
        }

        return $this->apiResponseBuilder->buildFormErrorResponse($form);
    }

    /**
     * @Route("/{id}", name="vehicle_delete", methods={"DELETE"})
     * @IsGranted({"ROLE_SUPER_ADMIN"})
     * @param Vehicle $vehicle
     * @return JsonResponse
     */
    public function delete(Vehicle $vehicle): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vehicle);
        $entityManager->flush();

        return $this->apiResponseBuilder->buildResponse($vehicle);
    }
}
