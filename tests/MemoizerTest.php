<?php

declare(strict_types=1);

namespace Kenny1911\Tests\Memoizer;

use Kenny1911\Memoizer\Cache\InMemoryCache;
use Kenny1911\Memoizer\Memoizer;
use Kenny1911\Memoizer\Normalizer\SimpleNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @psalm-internal Kenny1911\Tests\Memoizer
 */
final class MemoizerTest extends TestCase
{
    private Memoizer $memoizer;

    private int $calls = 0;

    #[\Override]
    protected function setUp(): void
    {
        $this->memoizer = new Memoizer(
            normalizer: new SimpleNormalizer(),
            cache: new InMemoryCache(),
        );

        $this->calls = 0;
    }

    /**
     * @psalm-suppress RedundantConditionGivenDocblockType
     * @psalm-suppress DocblockTypeContradiction
     */
    public function test(): void
    {
        $slowFunc = function (int $a, int $b): int {
            ++$this->calls;

            return $a + $b;
        };

        self::assertSame(3, $this->memoizer->memoize('1+2', static fn() => $slowFunc(1, 2)));
        self::assertSame(1, $this->calls);
        self::assertSame(3, $this->memoizer->memoize('1+2', static fn() => $slowFunc(1, 2)));
        self::assertSame(1, $this->calls);

        self::assertSame(7, $this->memoizer->memoize('3+4', static fn() => $slowFunc(3, 4)));
        self::assertSame(2, $this->calls);

        self::assertSame(3, $this->memoizer->memoize('1+2', static fn() => $slowFunc(1, 2)));
        self::assertSame(2, $this->calls);
    }

    /**
     * @psalm-suppress RedundantConditionGivenDocblockType
     * @psalm-suppress DocblockTypeContradiction
     */
    public function testCallMemoizedFunction(): void
    {
        self::assertSame(3, $this->memoizedSlowFunc(1, 2));
        self::assertSame(1, $this->calls);
        self::assertSame(3, $this->memoizedSlowFunc(1, 2));
        self::assertSame(1, $this->calls);

        self::assertSame(7, $this->memoizedSlowFunc(3, 4));
        self::assertSame(2, $this->calls);

        self::assertSame(3, $this->memoizedSlowFunc(1, 2));
        self::assertSame(2, $this->calls);
    }

    private function memoizedSlowFunc(int $a, int $b): int
    {
        return $this->memoizer->memoize([__METHOD__, \func_get_args()], function () use (&$a, &$b): int {
            ++$this->calls;

            return $a + $b;
        });
    }
}
