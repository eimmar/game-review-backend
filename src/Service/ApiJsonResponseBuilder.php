<?php


namespace App\Service;


use App\DTO\PaginationResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiJsonResponseBuilder
{
    /**
     * @var array
     */
    private array $corsAllowedUrls;

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, array $corsAllowedUrls)
    {
        $this->corsAllowedUrls = $corsAllowedUrls;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     */
    public function preflightResponse()
    {
        $headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, OPTIONS, DELETE',
            'Access-Control-Allow-Headers' => '*'
        ];
        return $this->respond([], 200, $headers);
    }

    /**
     * @param mixed $data
     * @param array $headers
     * @param int $status
     * @param array $serializerParams
     * @return JsonResponse
     */
    public function respond($data, $status = 200, $headers = [], $serializerParams = [])
    {
        $headers = array_merge($headers, [
            'Access-Control-Allow-Origin' => implode(', ', $this->corsAllowedUrls)
        ]);

        $serializerParams = array_merge(
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ],
            $serializerParams
        );

        return new JsonResponse($this->serializer->serialize($data, 'json', $serializerParams), $status, $headers, true);
    }

    public function respondWithPagination(PaginationResponse $paginationResponse, $serializerParams = [])
    {
        return $this->respond(
            [
                'page' => $paginationResponse->getPage(),
                'totalResults' => $paginationResponse->getTotalResults(),
                'pageSize' => $paginationResponse->getPageSize(),
                'items' => $paginationResponse->getItems()
            ],
            200,
            [],
            $serializerParams
        );
    }
}
