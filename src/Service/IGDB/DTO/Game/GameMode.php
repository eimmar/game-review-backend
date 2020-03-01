<?php

declare(strict_types=1);




namespace App\Service\IGDB\DTO;

use App\Service\IGDB\Traits\TimestampableTrait;
use App\Service\IGDB\Traits\UrlIdentifiableTrait;

class GameMode
{
    use TimestampableTrait;
    use UrlIdentifiableTrait;
}
