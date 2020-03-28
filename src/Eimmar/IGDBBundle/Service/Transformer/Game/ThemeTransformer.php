<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer\Game;

use App\Eimmar\IGDBBundle\DTO\Game\Theme;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class ThemeTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Theme(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }
}
