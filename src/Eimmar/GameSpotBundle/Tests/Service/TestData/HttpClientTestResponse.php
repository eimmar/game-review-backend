<?php

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

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Tests\Service\TestData;

use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClientTestResponse implements ResponseInterface
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getStatusCode(): int
    {
    }

    public function getHeaders(bool $throw = true): array
    {
    }

    public function getContent(bool $throw = true): string
    {
        return $this->content;
    }

    public function toArray(bool $throw = true): array
    {
    }

    public function cancel(): void
    {
    }

    public function getInfo(string $type = null)
    {
    }
}
