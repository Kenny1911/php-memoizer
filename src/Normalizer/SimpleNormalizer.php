<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Normalizer;

/**
 * @api
 */
final class SimpleNormalizer implements Normalizer
{
    #[\Override]
    public function normalize(mixed $key): string
    {
        return serialize($key);
    }
}
