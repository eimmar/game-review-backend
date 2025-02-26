<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Tests\Data;

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
        return 200;
    }

    public function getHeaders(bool $throw = true): array
    {
        return [];
    }

    public function getContent(bool $throw = true): string
    {
        return $this->content;
    }

    public function toArray(bool $throw = true): array
    {
        return [];
    }

    public function cancel(): void
    {
    }

    public function getInfo(string $type = null)
    {
    }
}
