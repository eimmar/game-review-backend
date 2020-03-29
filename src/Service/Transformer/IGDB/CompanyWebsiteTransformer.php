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


namespace App\Service\Transformer\IGDB;

use App\Entity\Company\Website;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class CompanyWebsiteTransformer implements IGDBTransformerInterface
{
    /**
     * @var Website[]
     */
    private array $companyWebsiteCache;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Company\Website $igdbWebsite
     * @return Website
     */
    public function transform($igdbWebsite)
    {
        if (isset($this->companyWebsiteCache[$igdbWebsite->getId()])) {
            $website = $this->companyWebsiteCache[$igdbWebsite->getId()];
        } else {
            $website = $this->entityManager->getRepository(Website::class)->findOneBy(['externalId' => $igdbWebsite->getId()]) ?: new Website();
            $website->setUrl($igdbWebsite->getUrl());
            $website->setExternalId($igdbWebsite->getId());
            $website->setCategory($igdbWebsite->getCategory());
            $website->setTrusted($igdbWebsite->getTrusted());

            $this->companyWebsiteCache[$igdbWebsite->getId()] = $website;
        }

        return $website;
    }
}
