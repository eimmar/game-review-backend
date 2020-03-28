<?php

declare(strict_types=1);

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
