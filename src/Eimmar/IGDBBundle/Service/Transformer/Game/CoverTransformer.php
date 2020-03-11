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


namespace App\Eimmar\IGDBBundle\Service\Transformer\Game;


use App\Eimmar\IGDBBundle\DTO\Game\Cover;
use App\Eimmar\IGDBBundle\Service\Transformer\AbstractTransformer;

class CoverTransformer extends AbstractTransformer
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

        return new Cover(
            (int)$this->getProperty($response, 'id'),
            $this->isNotObject($game) ? $game : $this->getProperty($game, 'id'),
            $this->getProperty($response, 'alpha_channel'),
            $this->getProperty($response, 'animated'),
            $this->getProperty($response, 'height'),
            $this->getProperty($response, 'image_id'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'width')
        );
    }
}
