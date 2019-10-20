<?php

declare(strict_types=1);

namespace Infrastructure\Cache;

use Predis\Client;

final class PredisCache implements Cache
{
    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function set(string $key, string $value, int $ttlSeconds = 0): void
    {
        $this->redis->setex($key, $ttlSeconds, $value);
    }

    public function get(string $key): ?string
    {
        return $this->redis->get($key);
    }
}
