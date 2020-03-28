<?php

declare(strict_types=1);

namespace App\Eimmar\IGDBBundle\Service\Transformer;

use App\Eimmar\IGDBBundle\DTO\TimeToBeat;

class TimeToBeatTransformer extends AbstractTransformer
{
    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        $game = $this->getProperty($response, 'game');

        return new TimeToBeat(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'completely'),
            $this->isNotObject($game) ? $game : $this->getProperty($game, 'id'),
            $this->getProperty($response, 'hastly'),
            $this->getProperty($response, 'normally')
        );
    }
}
