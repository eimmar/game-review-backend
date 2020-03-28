<?php

declare(strict_types=1);

namespace App\DTO;

class ChangePasswordRequest
{
    /**
     * @var string
     */
    private string $password;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
