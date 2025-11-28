# PHP Memoizer

\[English\]\[[Русский](./README-RU.md)\]

A library for memoizing function results in PHP. Allows caching function and method call results for performance optimization.

## Installation

```bash
composer require kenny1911/php-memoizer
```

## Quick Start

### Initialization

```php
use Kenny1911\Memoizer\Cache\InMemoryCache;
use Kenny1911\Memoizer\Memoizer;
use Kenny1911\Memoizer\Normalizer\SimpleNormalizer;

$memoizer = new Memoizer(
    normalizer: new SimpleNormalizer(),
    cache: new InMemoryCache(),
);
```

### Usage in Class

```php
final readonly class Calculator
{
    public function __construct(
        private Memoizer $memoizer,
    ) {}

    public function sum(int $a, int $b): int
    {
        return $this->memoizer->memoize([__METHOD__, \func_get_args()], function() use ($a, $b): int {
            return $a + $b;
        });
    }
}

$calculator = new Calculator($memoizer);

$calculator->sum(1, 2); // Calculates value: 3
$calculator->sum(1, 2); // Returns memoized value: 3

$calculator->sum(3, 4); // Calculates value: 7
```

## Components

### Memoizer

The main class for memoization. Accepts two parameters:
- `normalizer` - normalizer for creating cache keys
- `cache` - cache implementation

### Normalizers

#### SimpleNormalizer
Converts arguments to a string key using the standard PHP `serialize()` function. Suitable for most cases.

### Cache

#### InMemoryCache
Stores data in memory during script execution.

## Customization

To customize the memoizer, you can write and use your own implementation of a normalizer
(interface `Kenny1911\Memoizer\Normalizer\Normalizer`) and/or cache (interface `Kenny1911\Memoizer\Cache\Cache`).

## Recommendations

1. **Use unique keys** - include the method name and all relevant parameters in the key
2. **Avoid memoizing side effects** - memoization is only suitable for pure functions
3. **Consider memory usage** - especially when using InMemoryCache
4. **Test performance** - make sure memoization actually provides benefits

## License

MIT