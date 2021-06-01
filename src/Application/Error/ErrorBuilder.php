<?php

namespace App\Application\Error;

class ErrorBuilder implements ErrorBuilderInterface
{
    private string $code = 'INTERNAL_SERVER_ERROR';

    private string $type = 'SERVER_ERROR';

    private string $message = 'Internal server error';

    private ?int $plural = null;

    private ?string $propertyPath = null;

    public function setMessage(string $message): ErrorBuilderInterface
    {
        $this->message = $message;

        return $this;
    }

    public function setCode(string $code): ErrorBuilderInterface
    {
        $this->code = $code;

        return $this;
    }

    public function setType(string $type): ErrorBuilderInterface
    {
        $this->type = $type;

        return $this;
    }

    public function setPropertyPath(?string $propertyPath): ErrorBuilderInterface
    {
        $this->propertyPath = $propertyPath;

        return $this;
    }

    public function getError(): ErrorInterface
    {
        return new Error($this->code, $this->message, $this->type, $this->propertyPath);
    }
}
