<?php


namespace App\Domain\Entity;

use App\Infrastructure\Persistence\Doctrine\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;


class CountryStatistic
{
    public string $code;

    public int $count;
}