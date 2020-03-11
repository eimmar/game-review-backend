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


namespace App\Service\IGDB\Transformer;

use App\Service\IGDB\DTO\AgeRating;
use App\Service\IGDB\Transformer\AgeRating\ContentDescriptionTransformer;

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
