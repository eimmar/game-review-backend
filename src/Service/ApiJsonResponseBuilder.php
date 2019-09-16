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
    private $corsAllowedUrls;

    private $serializer;

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
            'Access-Control-Allow-Headers' => 'Origin, Authorization, X-Requested-With, Content-Type, Accept, Cache-Control'
        ];
        return $this->buildResponse([], 200, $headers);
    }

    /**
     * @param mixed $data
     * @param array $headers
     * @param int $status
     * @return JsonResponse
     */
    public function buildResponse($data, $status = 200, $headers = [])
    {
        $headers = array_merge($headers, [
            'Access-Control-Allow-Origin' => implode(', ', $this->corsAllowedUrls)
        ]);

        return new JsonResponse($this->serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]), $status, $headers, true);
    }

    /**
     * @param FormInterface $form
     * @return JsonResponse
     */
    public function buildFormErrorResponse(FormInterface $form)
    {
       $currentError =  $form->getErrors(true)->current();

       if ($currentError) {
           $msg = sprintf('%s: %s', ucfirst($currentError->getOrigin()->getName()), $currentError->getMessage());
       } else {
           $msg = 'Invalid form data.';
       }

       return $this->buildResponse($msg, 400);
    }
}
