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


namespace App\Eimmar\IGDBBundle\DTO\AgeRating;

use App\Eimmar\IGDBBundle\DTO\ResponseDTO;
use App\Eimmar\IGDBBundle\Traits\IdentifiableTrait;

class ContentDescription implements ResponseDTO
{
    use IdentifiableTrait;

    /**
     * @var int|null
     */
    private ?int $category;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @param int $id
     * @param int|null $category
     * @param string|null $description
     */
    public function __construct(int $id, ?int $category, ?string $description)
    {
        $this->id = $id;
        $this->category = $category;
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
