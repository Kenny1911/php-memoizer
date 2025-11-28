<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Cache;

/**
 * @api
 */
final class InvalidKey extends \RuntimeException
{
    public static function create(string $key): self
    {
        return new self(\sprintf('Cache item with key "%s" not exists.', $key));
    }
}
