<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\NameableEntity;

class NameableEntityTransformer extends AbstractDTOTransformer
{
    /**
     * @param array $response
     * @return NameableEntity
     */
    public function transform(array $response): NameableEntity
    {
        return new NameableEntity((string)$this->getProperty($response, 'name'));
    }
}
