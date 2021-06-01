<?php

namespace App\Application\Result;

interface ResultInterface
{
    public function isPassable(): bool;

    public function hasError(): bool;

    public function getData();
}
