<?php

declare(strict_types=1);

namespace App\Eimmar\IsThereAnyDealBundle\Transformer;

class ResponseTransformer
{
    public function transform(array &$response): array
    {
        foreach (array_keys($response) as $key) {
            $value = &$response[$key];
            unset($response[$key]);
            $transformedKey = lcfirst(str_replace('_', '', ucwords((string)$key, ' /_')));

            if (is_array($value)) {
                $this->transform($value);
            }

            $response[$transformedKey] = $value;
            unset($value);
        }

        return $response;
    }
}
