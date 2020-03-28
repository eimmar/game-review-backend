<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\AgeRating;
use App\Eimmar\IGDBBundle\Service\Transformer\AgeRating\ContentDescriptionTransformer;

class AgeRatingTransformer extends AbstractTransformer
{
    /**
     * @var ContentDescriptionTransformer
     */
    private ContentDescriptionTransformer $contentDescriptionTransformer;

    /**
     * AgeRatingTransformer constructor.
     * @param ContentDescriptionTransformer $contentDescriptionTransformer
     */
    public function __construct(ContentDescriptionTransformer $contentDescriptionTransformer)
    {
        $this->contentDescriptionTransformer = $contentDescriptionTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new AgeRating(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            array_map([$this->contentDescriptionTransformer, 'transform'], (array)$this->getProperty($response, 'content_descriptions')),
            $this->getProperty($response, 'rating'),
            $this->getProperty($response, 'rating_cover_url'),
            $this->getProperty($response, 'synopsis')
        );
    }
}
