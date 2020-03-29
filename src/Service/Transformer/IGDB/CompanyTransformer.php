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

use App\Entity\Game\Company;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Game;
use App\Eimmar\IGDBBundle\DTO as IGDB;
use Doctrine\ORM\EntityManagerInterface;

class CompanyTransformer implements IGDBTransformerInterface
{
    /**
     * @var Company[]
     */
    private array $companyCache;

    private CompanyWebsiteTransformer $companyWebsiteTransformer;

    private EntityManagerInterface $entityManager;

    /**
     * @param CompanyWebsiteTransformer $companyWebsiteTransformer
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CompanyWebsiteTransformer $companyWebsiteTransformer,
        EntityManagerInterface $entityManager
    ) {
        $this->companyWebsiteTransformer = $companyWebsiteTransformer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param IGDB\Game\InvolvedCompany $igdbInvolvedCompany
     * @return Company
     */
    public function transform($igdbInvolvedCompany)
    {
        $igdbCompany = $igdbInvolvedCompany->getCompany();

        if (isset($this->companyCache[$igdbCompany->getId()])) {
            $company = $this->companyCache[$igdbCompany->getId()];
        } else {
            $company = $this->entityManager->getRepository(Company::class)->findOneBy(['externalId' => $igdbCompany->getId()]) ?: new Game\Company();

            $company->setName($igdbCompany->getName());
            $company->setExternalId($igdbCompany->getId());
            $company->setDescription($igdbCompany->getDescription());
            $company->setUrl($igdbCompany->getUrl());

            $websites = new ArrayCollection(array_map([$this->companyWebsiteTransformer, 'transform'], $igdbCompany->getWebsites()));
            $company->setWebsites($websites);

            $this->companyCache[$igdbCompany->getId()] = $company;
        }

        return $company;
    }
}
