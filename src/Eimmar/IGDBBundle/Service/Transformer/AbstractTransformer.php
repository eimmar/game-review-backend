<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use stdClass;

abstract class AbstractTransformer
{
    /**
     * @param stdClass $object
     * @param string $propertyName
     * @return mixed|null
     */
    protected function getProperty(stdClass $object, string $propertyName)
    {
        return isset($object->$propertyName) ? $object->$propertyName : null;
    }

    /**
     * @param stdClass|int|null $response
     * @return bool
     */
    protected function isNotObject($response)
    {
        return !is_object($response) || !is_int($this->getProperty($response, 'id'));
    }

    /**
     * @param stdClass|int|null $response
     * @return ResponseDTO|stdClass|int|null
     */
    public abstract function transform($response);
}
