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

use App\Eimmar\GameSpotBundle\DTO\Game;

class GameTransformer extends AbstractDTOTransformer
{
    /**
     * @var ImageTransformer
     */
    private ImageTransformer $imageTransformer;

    /**
     * @var NameableEntityTransformer
     */
    private NameableEntityTransformer $nameableEntityTransformer;

    /**
     * @param ImageTransformer $imageTransformer
     * @param NameableEntityTransformer $nameableEntityTransformer
     */
    public function __construct(
        ImageTransformer $imageTransformer,
        NameableEntityTransformer $nameableEntityTransformer
    ) {
        $this->imageTransformer = $imageTransformer;
        $this->nameableEntityTransformer = $nameableEntityTransformer;
    }

    /**
     * @param \stdClass $response
     * @return Game
     */
    public function transform(\stdClass $response): Game
    {
        $image = $this->getProperty($response, 'image');

        return new Game(
            $this->getProperty($response, 'release_date'),
            $this->getProperty($response, 'description'),
            $this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'deck'),
            $image ? $this->imageTransformer->transform($image) : null,
            array_map([$this->nameableEntityTransformer, 'transform'], (array)$this->getProperty($response, 'genres')),
            array_map([$this->nameableEntityTransformer, 'transform'], (array)$this->getProperty($response, 'themes')),
            array_map([$this->nameableEntityTransformer, 'transform'], (array)$this->getProperty($response, 'franchises')),
            $this->getProperty($response, 'images_api_url'),
            $this->getProperty($response, 'reviews_api_url'),
            $this->getProperty($response, 'articles_api_url'),
            $this->getProperty($response, 'videos_api_url'),
            $this->getProperty($response, 'releases_api_url'),
            $this->getProperty($response, 'site_detail_url')
        );
    }
}
