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
