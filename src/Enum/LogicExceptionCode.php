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

namespace App\Enum;

class LogicExceptionCode
{
    const INVALID_DATA = 100;

    const AUTH_PASSWORD_CHANGE_ALREADY_REQUESTED = 200;
    const AUTH_EMAIL_ALREADY_EXISTS = 201;

    const GAME_LIST_DUPLICATE_NAME = 300;

    const FRIENDSHIP_USER_ALREADY_FRIEND = 400;
}
