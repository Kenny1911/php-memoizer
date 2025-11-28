<?php

declare(strict_types=1);

namespace Kenny1911\Tests\Memoizer\Normalizer;

use Kenny1911\Memoizer\Normalizer\Normalizer;
use Kenny1911\Memoizer\Normalizer\SimpleNormalizer;
use Kenny1911\Memoizer\Test\Normalizer\NormalizerTestCase;

/**
 * @internal
 * @psalm-internal Kenny1911\Tests\Memoizer\Normalizer
 */
final class SimpleNormalizerTest extends NormalizerTestCase
{
    #[\Override]
    protected function createNormalizer(): Normalizer
    {
        return new SimpleNormalizer();
    }
}
