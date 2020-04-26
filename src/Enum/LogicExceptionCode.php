<?php

declare(strict_types=1);

namespace App\Enum;

class LogicExceptionCode
{
    const INVALID_DATA = 100;

    const AUTH_PASSWORD_CHANGE_ALREADY_REQUESTED = 200;
    const AUTH_EMAIL_ALREADY_EXISTS = 201;

    const GAME_LIST_DUPLICATE_NAME = 300;

    const FRIENDSHIP_USER_ALREADY_FRIEND = 400;
}
