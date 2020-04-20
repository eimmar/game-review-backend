<?php

namespace App\Controller;

use App\Exception\LogicException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends BaseApiController
{
    public function show(Request $request, FlattenException $exception)
    {
        $statusCode = $exception->getClass() === LogicException::class ? 400 : $exception->getStatusCode();
        $statusText = isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : '';

        if (strpos($request->getPathInfo(), '/admin') === 0) {
            return new Response($statusText, $statusCode);
        }

        return $this->apiResponseBuilder->buildResponse(
            [
                'code' => (int)$exception->getCode(),
                'status' => isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : '',
            ],
            $statusCode
        );
    }
}
