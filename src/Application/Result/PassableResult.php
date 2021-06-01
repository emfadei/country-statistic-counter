<?php

namespace App\Application\Result;

final class PassableResult extends AbstractResult
{
    public function isPassable(): bool
    {
        return true;
    }

    public function hasError(): bool
    {
        return false;
    }
}
