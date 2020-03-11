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


namespace App\Service\GameSpot\Response;

use App\Service\GameSpot\DTO\DTO;

class Response implements DTO
{
    /**
     * @var string
     */
    private $error;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $numberOfPageResults;

    /**
     * @var int
     */
    private $numberOfTotalResults;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $results;

    /**
     * @var string
     */
    private $version;

    /**
     * @param string $error
     * @param int $limit
     * @param int $offset
     * @param int $numberOfPageResults
     * @param int $numberOfTotalResults
     * @param int $statusCode
     * @param array $results
     * @param string $version
     */
    public function __construct(
        string $error,
        int $limit,
        int $offset,
        int $numberOfPageResults,
        int $numberOfTotalResults,
        int $statusCode,
        array $results,
        string $version
    ) {
        $this->error = $error;
        $this->limit = $limit;
        $this->offset = $offset;
        $this->numberOfPageResults = $numberOfPageResults;
        $this->numberOfTotalResults = $numberOfTotalResults;
        $this->statusCode = $statusCode;
        $this->results = $results;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getNumberOfPageResults(): int
    {
        return $this->numberOfPageResults;
    }

    /**
     * @return int
     */
    public function getNumberOfTotalResults(): int
    {
        return $this->numberOfTotalResults;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
