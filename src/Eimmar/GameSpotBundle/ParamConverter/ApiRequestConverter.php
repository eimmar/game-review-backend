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


namespace App\Eimmar\GameSpotBundle\ParamConverter;

use App\Eimmar\GameSpotBundle\DTO\Request\ApiRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);

        if (!$content || !isset($content['format'])) {
            throw new \InvalidArgumentException('Invalid request parameters.');
        }

        $gamePricesRequest = new ApiRequest(
            $content['format'],
            isset($content['filter']) ? $content['filter']: null,
            isset($content['fieldList']) ? $content['fieldList']: null,
            isset($content['limit']) ? $content['limit']: null,
            isset($content['offset']) ? $content['offset']: null,
            isset($content['sort']) ? $content['sort']: null,
        );

        $request->attributes->set($configuration->getName(), $gamePricesRequest);
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === ApiRequest::class;
    }
}
