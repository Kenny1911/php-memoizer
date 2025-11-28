<?php

declare(strict_types=1);

namespace Kenny1911\Memoizer\Cache;

/**
 * @api
 */
interface Cache
{
    public function has(string $key): bool;

    /**
     * @throws InvalidKey
     */
    public function get(string $key): mixed;

    public function set(string $key, mixed $value): void;

    public function remove(string $key): void;

    public function removeAll(): void;
}
