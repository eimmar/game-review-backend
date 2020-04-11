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


namespace App\ParamConverter;

use App\DTO\SearchRequest;
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
        if (!$content || !isset($content['page']) || !isset($content['pageSize']) || !isset($content['filters'])) {
            throw new \InvalidArgumentException('Invalid request parameters.');
        }

        $sortBy = isset($content['sortBy']) ? $content['sortBy'] : null;
        $order = isset($content['order']) ? $content['order'] : null;

        $request->attributes->set(
            $configuration->getName(),
            new SearchRequest(
                $content['page'], $content['pageSize'], $content['filters'], $sortBy, $order
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
