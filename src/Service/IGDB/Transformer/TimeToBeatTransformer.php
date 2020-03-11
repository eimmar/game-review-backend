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

use App\Service\IGDB\DTO\TimeToBeat;

class TimeToBeatTransformer extends AbstractTransformer
{
    private GameTransformer $gameTransformer;

    /**
     * @param GameTransformer $gameTransformer
     */
    public function __construct(GameTransformer $gameTransformer)
    {
        $this->gameTransformer = $gameTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new TimeToBeat(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'completely'),
            $this->gameTransformer->transform($this->getProperty($response, 'game')),
            $this->getProperty($response, 'hastly'),
            $this->getProperty($response, 'normally')
        );
    }
}
