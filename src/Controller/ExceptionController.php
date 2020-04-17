<?php

namespace App\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends BaseApiController
{
    public function show(Request $request, FlattenException $exception)
    {
        $code = $exception->getStatusCode();
        $statusText = isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '';

        if (strpos($request->getPathInfo(), '/admin') === 0) {
            return new Response($statusText, $code);
        }

        return $this->apiResponseBuilder->buildResponse(
            [
                'status_code' => $code,
                'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
            ],
            $code
        );
    }
}
