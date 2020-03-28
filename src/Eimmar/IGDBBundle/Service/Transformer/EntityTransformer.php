<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer;


class EntityTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return $this->getProperty($response, 'id');
    }
}
