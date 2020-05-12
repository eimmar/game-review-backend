<?php

declare(strict_types=1);

namespace App\ParamConverter;

use App\DTO\ForgotPasswordRequest;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordRequestConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent(), true);
        if (!$content || !isset($content['email'])) {
            throw new InvalidArgumentException('Invalid request parameters.');
        }

        $request->attributes->set($configuration->getName(), new ForgotPasswordRequest($content['email']));
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === ForgotPasswordRequest::class;
    }
}
