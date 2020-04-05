<?php

declare(strict_types=1);

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */


namespace App\Eimmar\IsThereAnyDealBundle\ParamConverter;

use App\Eimmar\IsThereAnyDealBundle\DTO\Request\GamePricesRequest;
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
            throw new \InvalidArgumentException('Invalid request parameters.');
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