<?php

namespace App\Domain\Entity;

use Ramsey\Collection\Map\AbstractTypedMap;

class CountryStatisticMap extends AbstractTypedMap
{
    public function getKeyType(): string
    {
        return 'string';
    }

    public function getValueType(): string
    {
        return 'string';
    }
}
