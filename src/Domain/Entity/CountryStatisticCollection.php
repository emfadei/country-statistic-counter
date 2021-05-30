<?php


namespace App\Domain\Entity;


use Ramsey\Collection\AbstractCollection;

class CountryStatisticCollection extends AbstractCollection
{
    public function getType(): string
    {
        return CountryStatistic::class;
    }
}