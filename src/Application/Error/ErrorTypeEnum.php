<?php


namespace App\Application\Error;


use MyCLabs\Enum\Enum;

class ErrorTypeEnum extends Enum
{
    public const CLIENT_ERROR    = 'clientError';
    public const INVALID_REQUEST = 'invalidRequest';
}