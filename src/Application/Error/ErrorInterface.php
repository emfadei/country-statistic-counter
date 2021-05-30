<?php


namespace App\Application\Error;

use App\Application\Result\ResultInterface;

interface ErrorInterface extends ResultInterface
{
    public function getMessage(): string;

    public function getCode(): string;

    public function getType(): string;

    public function getPropertyPath(): ?string;
}