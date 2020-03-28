<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer\Game;

use App\Eimmar\IGDBBundle\DTO\Game\PlayerPerspective;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class PlayerPerspectiveTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new PlayerPerspective(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }
}
