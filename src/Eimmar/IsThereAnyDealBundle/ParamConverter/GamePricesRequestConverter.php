<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\ParamConverter;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class GamePricesRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);

        if (!$content || !isset($content['plains'])) {
            throw new InvalidArgumentException('Invalid request parameters.');
        }

        $gamePricesRequest = new GamePricesRequest(
            $content['plains'],
            isset($content['region']) ? $content['region']: null,
            isset($content['country']) ? $content['country']: null,
            isset($content['shops']) ? $content['shops']: null,
            isset($content['exclude']) ? $content['exclude']: null,
            isset($content['added']) ? $content['added']: null,
        );

        $request->attributes->set($configuration->getName(), $gamePricesRequest);
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === GamePricesRequest::class;
    }
}
