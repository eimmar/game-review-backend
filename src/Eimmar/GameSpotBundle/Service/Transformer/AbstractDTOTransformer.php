<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\DTO;

abstract class AbstractDTOTransformer
{
    /**
     * @param \stdClass $object
     * @param string $propertyName
     * @return mixed|null
     */
    protected function getProperty(\stdClass $object, string $propertyName)
    {
        return isset($object->$propertyName) ? $object->$propertyName : null;
    }

    /**
     * @param \stdClass $response
     * @return DTO
     */
    public abstract function transform(\stdClass $response): DTO;
}
