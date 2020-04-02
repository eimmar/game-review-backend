<?php


namespace App\Service;


use Symfony\Component\Form\FormInterface;
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
        return $this->buildResponse([], 200, $headers);
    }

    /**
     * @param mixed $data
     * @param array $headers
     * @param int $status
     * @param array $serializerParams
     * @return JsonResponse
     */
    public function buildResponse($data, $status = 200, $headers = [], $serializerParams = [])
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

    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function buildMessageResponse($message, $status = 200, $headers = [])
    {
        return $this->buildResponse(['message' => $message], $status, $headers);
    }

    /**
     * @param FormInterface $form
     * @return JsonResponse
     */
    public function buildFormErrorResponse(FormInterface $form)
    {
       $currentError = $form->getErrors(true)->current();

       if ($currentError) {
           $msg = sprintf('%s: %s', ucfirst($currentError->getOrigin()->getName()), $currentError->getMessage());
       } else {
           $msg = 'Invalid form data.';
       }

       return $this->buildResponse(['message' => $msg], 400);
    }
}
