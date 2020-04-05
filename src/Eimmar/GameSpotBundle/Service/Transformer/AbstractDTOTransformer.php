<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\DTO;

abstract class AbstractDTOTransformer
{
    /**
     * @param array $data
     * @param string $propertyName
     * @return mixed|null
     */
    protected function getProperty(array $data, string $propertyName)
    {
        return isset($data[$propertyName]) ? $data[$propertyName] : null;
    }

    /**
     * @param array $response
     * @return DTO
     */
    public abstract function transform(array $response): DTO;
}
