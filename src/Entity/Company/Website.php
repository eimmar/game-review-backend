<?php

declare(strict_types=1);




namespace App\Entity\Company;

use App\Entity\ExternalEntityInterface;
use App\Entity\Game\Company;
use App\Traits\ExternalEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_website")
 */
class Website implements ExternalEntityInterface
{
    use ExternalEntityTrait;

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $trusted;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $url;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $category;

    /**
     * @var Company
     * @ORM\ManyToOne(targetEntity="App\Entity\Game\Company", inversedBy="websites")
     */
    private Company $company;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isTrusted(): bool
    {
        return $this->trusted;
    }

    /**
     * @param bool $trusted
     */
    public function setTrusted(bool $trusted): void
    {
        $this->trusted = $trusted;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company): void
    {
        $this->company = $company;
    }
}
