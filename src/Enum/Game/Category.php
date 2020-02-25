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


namespace App\Enum\Game;

final class Category
{
    const MAIN_GAME = 0;
    const DCL_ADDON = 1;
    const EXPANSION = 2;
    const BUNDLE  = 3;
    const STANDALONE_EXPANSION  = 4;
}
