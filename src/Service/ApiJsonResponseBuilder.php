<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiJsonResponseBuilder
{
    /**
     * @var array
     */
    private $corsAllowedUrls;

    private $serializer;

    public function __construct(SerializerInterface $serializer, array $corsAllowedUrls)
    {
        $this->corsAllowedUrls = $corsAllowedUrls;
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function buildResponse($data)
    {
        return new JsonResponse($this->serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]), 200, [
            'Access-Control-Allow-Origin' => implode(', ', $this->corsAllowedUrls)
        ], true);
    }
}
