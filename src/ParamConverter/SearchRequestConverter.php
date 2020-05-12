<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\DTO\SearchRequest;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);
        if (!$content || !isset($content['page']) || (!isset($content['pageSize']) && !isset($content['firstResult'])) || !isset($content['filters'])) {
            throw new InvalidArgumentException('Invalid request parameters.');
        }

        $orderBy = isset($content['orderBy']) ? $content['orderBy'] : null;
        $order = isset($content['order']) ? $content['order'] : null;

        $request->attributes->set(
            $configuration->getName(),
            new SearchRequest(
                $content['page'],
                isset($content['pageSize']) ? $content['pageSize'] : null,
                $content['filters'],
                $orderBy,
                $order,
                isset($content['firstResult']) ? $content['firstResult'] : null
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === SearchRequest::class;
    }
}
