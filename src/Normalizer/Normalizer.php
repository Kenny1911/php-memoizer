<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Normalizer;

/**
 * @api
 */
interface Normalizer
{
    public function normalize(mixed $key): string;
}
