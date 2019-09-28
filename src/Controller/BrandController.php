<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/brand")
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

    /**
     * @Route("/test", name="brand_test", methods={"GET"})
     */
    public function test()
    {
        return new Response("Test");
    }
}
