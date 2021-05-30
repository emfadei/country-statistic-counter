<?php


namespace App\Application\Error;



class Error implements ErrorInterface
{
    private string $code;

    private string $message;

    private ?string $propertyPath;

    private string $type;

    public function __construct(string $code, string $message, string $type, ?string $propertyPath = null)
    {
        $this->code         = $code;
        $this->message      = $message;
        $this->propertyPath = $propertyPath;
        $this->type         = $type;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPropertyPath(): ?string
    {
        return $this->propertyPath;
    }


    public function hasError(): bool
    {
        return true;
    }

    public function isPassable(): bool
    {
        return false;
    }

    public function getData()
    {
        return $this;
    }
}