<?php


namespace App\Application\Result;

final class ErrorResult extends AbstractResult
{
    public function isPassable(): bool
    {
        return false;
    }

    public function hasError(): bool
    {
        return true;
    }
}