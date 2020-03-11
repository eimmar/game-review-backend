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


namespace App\Eimmar\IGDBBundle\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\Platform;

class PlatformTransformer extends AbstractTransformer
{
    private EntityTransformer $entityTransformer;

    /**
     * @param EntityTransformer $entityTransformer
     */
    public function __construct(EntityTransformer $entityTransformer)
    {
        $this->entityTransformer = $entityTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Platform(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'abbreviation'),
            $this->getProperty($response, 'alternative_name'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'generation'),
            $this->entityTransformer->transform($this->getProperty($response, 'platform_logo')),
            $this->entityTransformer->transform($this->getProperty($response, 'product_family')),
            $this->getProperty($response, 'summary'),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'versions')),
            array_map([$this->entityTransformer, 'transform'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at')
        );
    }
}
