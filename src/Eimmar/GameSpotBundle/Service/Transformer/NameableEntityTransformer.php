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


namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\NameableEntity;

class NameableEntityTransformer extends AbstractDTOTransformer
{
    /**
     * @param \stdClass $response
     * @return NameableEntity
     */
    public function transform(\stdClass $response): NameableEntity
    {
        return new NameableEntity((string)$this->getProperty($response, 'name'));
    }
}
