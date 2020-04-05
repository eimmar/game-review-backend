<?php

declare(strict_types=1);

namespace App\Eimmar\GameSpotBundle\Service\Transformer;

use App\Eimmar\GameSpotBundle\DTO\Response\GamesResponse;
use App\Eimmar\GameSpotBundle\DTO\Response\Response;
use App\Eimmar\GameSpotBundle\DTO\Response\ReviewsResponse;

class ResponseTransformer
{
    /**
     * @param array $response
     * @param AbstractDTOTransformer|null $resultsTransformer
     * @return Response|ReviewsResponse|GamesResponse
     */
    public function transform(array $response, AbstractDTOTransformer $resultsTransformer = null)
    {
        $results = $response['results'];

        if ($resultsTransformer) {
            $results = array_map([$resultsTransformer, 'transform'], $results);
        } else {
            $this->toCamelCase($results);
        }

        return new Response(
            $response['error'],
            $response['limit'],
            $response['offset'],
            $response['number_of_page_results'],
            $response['number_of_total_results'],
            $response['status_code'],
            $results,
            $response['version']
        );
    }

    private function toCamelCase(array &$response): array
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
