<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer;

use Kenny1911\Memoizer\Cache\Cache;
use Kenny1911\Memoizer\Normalizer\Normalizer;

/**
 * @api
 */
final class Memoizer
{
    public function __construct(
        private readonly Normalizer $normalizer,
        private readonly Cache $cache,
    ) {}

    /**
     * @template T
     *
     * @param callable(): T $cb
     *
     * @return T
     */
    public function memoize(mixed $key, callable $cb): mixed
    {
        $cacheKey = $this->normalizer->normalize($key);

        if (!$this->cache->has($cacheKey)) {
            $this->cache->set($cacheKey, $cb());
        }

        /** @psalm-suppress MixedReturnStatement */
        return $this->cache->get($cacheKey);
    }

    public function reset(mixed $key): void
    {
        $cacheKey = $this->normalizer->normalize($key);
        $this->cache->remove($cacheKey);
    }

    public function resetAll(): void
    {
        $this->cache->removeAll();
    }
}
