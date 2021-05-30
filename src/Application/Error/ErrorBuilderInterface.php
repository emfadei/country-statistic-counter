<?php


namespace App\Application\Error;


interface ErrorBuilderInterface
{
    public function setMessage(string $message): self;

    public function setCode(string $code): self;

    public function setPropertyPath(?string $propertyPath): self;

    public function setType(string $type): self;

    public function getError(): ErrorInterface;
}