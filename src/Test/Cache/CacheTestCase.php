<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Test\Cache;

use Kenny1911\Memoizer\Cache\Cache;
use Kenny1911\Memoizer\Cache\InvalidKey;
use PHPUnit\Framework\TestCase;

/**
 * @api
 */
abstract class CacheTestCase extends TestCase
{
    abstract protected function createCache(): Cache;

    final public function test(): void
    {
        $cache = $this->createCache();

        self::assertFalse($cache->has('foo'));

        $cache->set('foo', 123);

        self::assertTrue($cache->has('foo'));
        self::assertSame(123, $cache->get('foo'));

        $cache->set('bar', 123);
        $cache->set('baz', 789);
        $cache->set('bar', 456);

        self::assertTrue($cache->has('foo'));
        self::assertSame(123, $cache->get('foo'));
        self::assertTrue($cache->has('bar'));
        self::assertSame(456, $cache->get('bar'));
        self::assertTrue($cache->has('baz'));
        self::assertSame(789, $cache->get('baz'));

        $cache->remove('foo');
        self::assertFalse($cache->has('foo'));
        self::assertTrue($cache->has('bar'));
        self::assertSame(456, $cache->get('bar'));
        self::assertTrue($cache->has('baz'));
        self::assertSame(789, $cache->get('baz'));

        $cache->removeAll();

        self::assertFalse($cache->has('foo'));
        self::assertFalse($cache->has('bar'));
        self::assertFalse($cache->has('baz'));
    }

    final public function testInvalidKey(): void
    {
        self::expectException(InvalidKey::class);

        $this->createCache()->get('foo');
    }
}
