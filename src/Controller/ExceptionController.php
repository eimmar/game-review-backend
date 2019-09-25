<?php


namespace App\Controller;


use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends BaseApiController
{
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {

        $code = $exception->getStatusCode();

        return $this->apiResponseBuilder->buildResponse(
            [
                'status_code' => $code,
                'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
            ],
            $code
        );
    }
}
