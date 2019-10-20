<?php

declare(strict_types=1);

namespace Infrastructure\Cache;

interface Cache
{
    public function set(string $key, string $value, int $ttlSeconds = 0): void;

    public function get(string $key): ?string;
}
