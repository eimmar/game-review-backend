<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/brand")
 */
class BrandController extends BaseApiController
{
    /**
     * @Route("/", name="brand_index", methods={"GET"})
     */
    public function index(BrandRepository $brandRepository): JsonResponse
    {
        return $this->apiResponseBuilder->buildResponse($brandRepository->findAll());
    }
}
