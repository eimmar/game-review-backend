<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class NonAdminUserException extends AccountStatusException
{
    /**
     * @return string
     */
    public function getMessageKey()
    {
        return 'Invalid credentials.';
    }
}
