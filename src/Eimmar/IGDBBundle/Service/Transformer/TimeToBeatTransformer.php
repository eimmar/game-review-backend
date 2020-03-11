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
