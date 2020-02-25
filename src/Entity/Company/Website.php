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


namespace App\Entity\Company;

use App\Entity\Game\Company;

class Website
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $externalId;

    /**
     * @var bool
     * @ORM\Column(type="bool", nullable=false)
     */
    private $trusted;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $category;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="websites")
     */
    private $company;
}
