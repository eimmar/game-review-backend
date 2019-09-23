<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\ModelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/model")
 */
class ModelController extends BaseApiController
{
    /**
     * @Route("/", name="model_index", methods={"GET"})
     */
    public function index(ModelRepository $modelRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($modelRepository->findAll());
    }

    /**
     * @Route("/brand/{brand}", name="model_by_brand", methods={"GET"})
     */
    public function showByBrand(Brand $brand): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($brand->getModels());
    }
}
