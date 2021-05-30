<?php


namespace App\Application\Error;



class ErrorFactory
{
    private ErrorBuilderInterface $errorBuilder;

    public function __construct(ErrorBuilderInterface $errorBuilder)
    {
        $this->errorBuilder = $errorBuilder;
    }

    public function createClientError(string $message, string $code, ?string $propertyPath = null): ErrorInterface
    {
        return $this->errorBuilder
            ->setMessage($message)
            ->setCode($code)
            ->setType(ErrorTypeEnum::CLIENT_ERROR)
            ->setPropertyPath($propertyPath)
            ->getError();
    }

    public function createInvalidRequestError(string $message): ErrorInterface
    {
        return $this->errorBuilder
            ->setMessage('Invalid request: '.$message)
            ->setCode(ErrorCode::INVALID_REQUEST)
            ->setType(ErrorTypeEnum::CLIENT_ERROR)
            ->getError();
    }
}