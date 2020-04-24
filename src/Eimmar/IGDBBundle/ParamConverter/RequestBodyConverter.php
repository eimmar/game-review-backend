<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\ParamConverter;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestBodyConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);

        $gamePricesRequest = new RequestBody(
            isset($content['fields']) ? $content['fields']: [],
            isset($content['where']) ? $content['where']: [],
            isset($content['sort']) ? $content['sort']: '',
            isset($content['search']) ? $content['search']: '',
            isset($content['limit']) ? $content['limit']: 10,
            isset($content['offset']) ? $content['offset']: 0,
        );

        $request->attributes->set($configuration->getName(), $gamePricesRequest);
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === RequestBody::class;
    }
}
