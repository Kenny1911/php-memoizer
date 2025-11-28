<?php

declare(strict_types=1);

namespace Kenny1911\Tests\Memoizer\Cache;

use Kenny1911\Memoizer\Cache\Cache;
use Kenny1911\Memoizer\Cache\InMemoryCache;
use Kenny1911\Memoizer\Test\Cache\CacheTestCase;

/**
 * @internal
 * @psalm-internal Kenny1911\Tests\Memoizer\Cache
 */
final class InMemoryCacheTest extends CacheTestCase
{
    #[\Override]
    protected function createCache(): Cache
    {
        return new InMemoryCache();
    }
}
