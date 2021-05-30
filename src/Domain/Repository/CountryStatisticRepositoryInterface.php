<?php


namespace App\Domain\Repository;


use App\Domain\Entity\CountryStatisticMap;

interface CountryStatisticRepositoryInterface
{
    public function increaseByCode(string $countryName): void;

    public function getAll(): CountryStatisticMap;
}