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


namespace App\Service\GameSpot\Transformer;

use App\Service\GameSpot\DTO\DTO;

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
