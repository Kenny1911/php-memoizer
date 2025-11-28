<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Test\Normalizer;

use Kenny1911\Memoizer\Normalizer\Normalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @api
 */
abstract class NormalizerTestCase extends TestCase
{
    abstract protected function createNormalizer(): Normalizer;

    #[DataProvider('dataNormalizeSameKey')]
    #[DataProvider('dataNormalizeSameKeyAdditional')]
    final public function testNormalizeSameKey(mixed $key1, mixed $key2): void
    {
        $normalizer = $this->createNormalizer();
        $normalizedKey1 = $normalizer->normalize($key1);

        self::assertSame($normalizedKey1, $normalizer->normalize($key1));
        self::assertSame($normalizedKey1, $normalizer->normalize($key2));
    }

    /**
     * @return iterable<array-key, array{0: mixed, 1: mixed}>
     */
    final public static function dataNormalizeSameKey(): iterable
    {
        yield ['foo', 'foo'];
        yield [123, 123];
        yield [123.45, 123.45];
        yield [true, true];
        yield [null, null];
        yield [[1, 2, 3], [1, 2, 3]];
        yield [new \DateTimeImmutable('2025-01-01 00:00:00'), new \DateTimeImmutable('2025-01-01 00:00:00')];
        yield [[new \DateTimeImmutable('2025-01-01 00:00:00')], [new \DateTimeImmutable('2025-01-01 00:00:00')]];
    }

    /**
     * @return iterable<array-key, array{0: mixed, 1: mixed}>
     */
    final public static function dataNormalizeSameKeyAdditional(): iterable
    {
        return [];
    }
}
