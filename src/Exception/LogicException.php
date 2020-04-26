<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class LogicException extends Exception
{
    /**
     * @param int $code
     * @param string $message
     */
    public function __construct($code = 0, string $message = "")
    {
        parent::__construct($message, $code, null);

    }
}
