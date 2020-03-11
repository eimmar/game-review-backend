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

use App\Eimmar\GameSpotBundle\DTO\Image;

class ImageTransformer extends AbstractDTOTransformer
{
    /**
     * @param \stdClass $response
     * @return Image
     */
    public function transform(\stdClass $response): Image
    {
        return new Image(
            (string)$this->getProperty($response, 'square_tiny'),
            (string)$this->getProperty($response, 'screen_tiny'),
            (string)$this->getProperty($response, 'square_small'),
            (string)$this->getProperty($response, 'original')
        );
    }
}
