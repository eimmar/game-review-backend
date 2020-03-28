<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer\Game;

use App\Eimmar\IGDBBundle\DTO\Game\Screenshot;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class ScreenshotTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Screenshot(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'alpha_channel'),
            $this->getProperty($response, 'animated'),
            $this->getProperty($response, 'height'),
            $this->getProperty($response, 'image_id'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'width')
        );
    }
}
