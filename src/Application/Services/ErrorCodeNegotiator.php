<?php

namespace App\Application\Services;

use App\Application\Error\ErrorInterface;
use App\Application\Error\ErrorTypeEnum;
use Symfony\Component\HttpFoundation\Response;

class ErrorCodeNegotiator
{
    public const HTTP_CODE_BY_ERROR_TYPE_MAP = [
        ErrorTypeEnum::CLIENT_ERROR  => Response::HTTP_BAD_REQUEST,
    ];

    public function negotiateHttpCode(ErrorInterface $error): int
    {
        $errorType = new ErrorTypeEnum($error->getType());

        return self::HTTP_CODE_BY_ERROR_TYPE_MAP[$errorType->getValue()];
    }
}
