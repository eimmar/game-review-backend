<?php

declare(strict_types=1);

namespace App\Service\Transformer\IGDB;


interface IGDBTransformerInterface
{
    public function transform($DTO);
}
