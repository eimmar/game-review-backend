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


namespace App\Service\IGDB\Transformer\Game;


use App\Service\IGDB\DTO\Game\Cover;
use App\Service\IGDB\Transformer\AbstractTransformer;
use App\Service\IGDB\Transformer\GameTransformer;

class CoverTransformer extends AbstractTransformer
{
    private GameTransformer $responseToGameTransformer;

    /**
     * CoverTransformer constructor.
     * @param GameTransformer $responseToGameTransformer
     */
    public function __construct(GameTransformer $responseToGameTransformer)
    {
        $this->responseToGameTransformer = $responseToGameTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Cover(
            (int)$this->getProperty($response, 'id'),
            $this->responseToGameTransformer->transform($this->getProperty($response, 'game')),
            $this->getProperty($response, 'alpha_channel'),
            $this->getProperty($response, 'animated'),
            $this->getProperty($response, 'height'),
            $this->getProperty($response, 'image_id'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'width')
        );
    }
}
