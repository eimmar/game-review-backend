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

use App\Service\IGDB\DTO\Game\InvolvedCompany;
use App\Service\IGDB\Transformer\AbstractTransformer;
use App\Service\IGDB\Transformer\CompanyTransformer;

class InvolvedCompanyTransformer extends AbstractTransformer
{
    /**
     * @var CompanyTransformer
     */
    private CompanyTransformer $companyTransformer;

    /**
     * @param CompanyTransformer $companyTransformer
     */
    public function __construct(CompanyTransformer $companyTransformer)
    {
        $this->companyTransformer = $companyTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        $game = $this->getProperty($response, 'game');

        return new InvolvedCompany(
            (int)$this->getProperty($response, 'id'),
            $this->companyTransformer->transform($this->getProperty($response, 'company')),
            $this->getProperty($response, 'developer'),
            $this->isNotObject($game) ? $game : $this->getProperty($game, 'id'),
            $this->getProperty($response, 'porting'),
            $this->getProperty($response, 'publisher'),
            $this->getProperty($response, 'supporting'),
            $this->getProperty($response, 'created_at'),
            $this->getProperty($response, 'updated_at')
        );
    }
}
