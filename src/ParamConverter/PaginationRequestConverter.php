<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\DTO\PaginationRequest;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class PaginationRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);
        if (!$content || !isset($content['page']) || (!isset($content['pageSize']) && !isset($content['firstResult']))) {
            throw new InvalidArgumentException('Invalid request parameters.');
        }

        $request->attributes->set($configuration->getName(), new PaginationRequest(
            $content['page'],
            isset($content['pageSize']) ? $content['pageSize'] : null,
            isset($content['firstResult']) ? $content['firstResult'] : null
        ));
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === PaginationRequest::class;
    }
}
