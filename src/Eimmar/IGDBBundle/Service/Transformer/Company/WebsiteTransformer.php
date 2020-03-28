<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer\Company;

use App\Eimmar\IGDBBundle\DTO\Company\Website;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class WebsiteTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Website(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'category'),
            $this->getProperty($response, 'trusted'),
            $this->getProperty($response, 'url')
        );
    }
}
