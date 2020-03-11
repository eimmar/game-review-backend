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

use App\Service\IGDB\DTO\Company;
use App\Service\IGDB\Transformer\Company\WebsiteTransformer;

class CompanyTransformer extends AbstractTransformer
{
    /**
     * @var EntityTransformer
     */
    private EntityTransformer $entityTransformer;

    /**
     * @var WebsiteTransformer
     */
    private WebsiteTransformer $websiteTransformer;

    /**
     * CompanyTransformer constructor.
     * @param EntityTransformer $entityTransformer
     * @param WebsiteTransformer $websiteTransformer
     */
    public function __construct(EntityTransformer $entityTransformer, WebsiteTransformer $websiteTransformer)
    {
        $this->entityTransformer = $entityTransformer;
        $this->websiteTransformer = $websiteTransformer;
    }

    /**
     * @inheritDoc
     */
    public function transform($response)
    {
        if ($this->isNotObject($response)) {
            return $response;
        }

        return new Company(
            (int)$this->getProperty($response, 'id'),
            $this->getProperty($response, 'change_date'),
            $this->getProperty($response, 'change_date_category'),
            $this->entityTransformer->transform($this->getProperty($response, 'changed_company_id')),
            $this->getProperty($response, 'country'),
            $this->getProperty($response, 'description'),
            $this->entityTransformer->transform($this->getProperty($response, 'logo')),
            $this->transform($this->getProperty($response, 'parent')),
            array_map([$this, 'transform'], (array)$this->getProperty($response, 'published')),
            $this->getProperty($response, 'start_date'),
            array_map([$this->websiteTransformer, 'transform'], (array)$this->getProperty($response, 'websites')),
            $this->getProperty($response, 'name'),
            $this->getProperty($response, 'url'),
            $this->getProperty($response, 'slug'),
            $this->getProperty($response, 'updated_at'),
            $this->getProperty($response, 'created_at')
        );
    }
}
