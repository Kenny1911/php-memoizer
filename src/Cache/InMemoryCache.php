<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Cache;

/**
 * @api
 */
final class InMemoryCache implements Cache
{
    /** @var array<string, mixed> */
    private array $cache = [];

    #[\Override]
    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->cache);
    }

    #[\Override]
    public function get(string $key): mixed
    {
        return $this->cache[$key] ?? throw InvalidKey::create($key);
    }

    #[\Override]
    public function set(string $key, mixed $value): void
    {
        $this->cache[$key] = $value;
    }

    #[\Override]
    public function remove(string $key): void
    {
        unset($this->cache[$key]);
    }

    #[\Override]
    public function removeAll(): void
    {
        $this->cache = [];
    }
}
