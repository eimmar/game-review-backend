<?php

namespace App\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends BaseApiController
{
    public function showAction(FlattenException $exception)
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
