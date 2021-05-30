<?php

namespace App\Tests\Acceptance\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use PHPUnit\Framework\Assert;
use Predis\ClientInterface;

class ApplicationContext implements Context
{
    private ClientInterface $redis;

    private string $keyPrefix;

    public function __construct(ClientInterface $redis, string $keyPrefix)
    {
        $this->redis     = $redis;
        $this->keyPrefix = $keyPrefix;
    }

    /** @BeforeScenario */
    public function clearData(): void
    {
        $this->redis->flushdb();
    }

    /** @BeforeStep */
    public function beforeStep(BeforeStepScope $scope): void
    {

    }

    /**
     * @Then there is value :value in redis storage by key :key
     */
    public function thereIsValueInRedis(string $value, string $key): void
    {
        Assert::assertTrue(
            (bool) $this->redis->exists($this->keyPrefix),
            sprintf('Value by given key "%s" does not exist in redis.', $key)
        );

        $data = $this->redis->hget($this->keyPrefix, $key);

        Assert::assertEquals($value, $data);
    }

    /**
     * @Then I have counter with key :key by value :value
     */
    public function iHaveDataInRedisStorage(int $value, string $key): void
    {
        $this->redis->hincrby($this->keyPrefix,$key, $value);
    }
}
