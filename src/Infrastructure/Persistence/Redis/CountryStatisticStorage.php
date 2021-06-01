<?php

namespace App\Infrastructure\Persistence\Redis;

use App\Domain\Entity\CountryStatisticMap;
use App\Domain\Repository\CountryStatisticRepositoryInterface;
use Predis\ClientInterface;

class CountryStatisticStorage implements CountryStatisticRepositoryInterface
{
    private ClientInterface $redis;

    private string $keyPrefix;

    public function __construct(ClientInterface $redis, string $keyPrefix)
    {
        $this->redis     = $redis;
        $this->keyPrefix = $keyPrefix;
    }

    public function increaseByCode(string $countryName): void
    {
        $this->redis->hincrby($this->keyPrefix, $countryName, 1);
    }

    public function getAll(): CountryStatisticMap
    {
        return new CountryStatisticMap($this->redis->hgetall($this->keyPrefix));
    }
}
