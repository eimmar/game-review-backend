<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer\AgeRating;

use App\Eimmar\IGDBBundle\DTO\AgeRating\ContentDescription;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class ContentDescriptionTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new ContentDescription(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'description')
        );
    }
}
