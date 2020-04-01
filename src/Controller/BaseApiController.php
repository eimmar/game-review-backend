<?php


namespace App\Controller;


use App\Service\ApiJsonResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseApiController extends AbstractController
{
    /**
     * @var ApiJsonResponseBuilder
     */
    protected ApiJsonResponseBuilder $apiResponseBuilder;

    public function __construct(ApiJsonResponseBuilder $builder)
    {
        $this->apiResponseBuilder = $builder;
    }
}
