# PHP Memoizer

\[[English](./README.md)\]\[Русский\]

Библиотека для мемоизации результатов функций в PHP. Позволяет кэшировать результаты вызовов функций и методов для оптимизации производительности.

## Установка

```bash
composer require kenny1911/php-memoizer
```

## Быстрый старт

### Инициализация

```php
use Kenny1911\Memoizer\Cache\InMemoryCache;
use Kenny1911\Memoizer\Memoizer;
use Kenny1911\Memoizer\Normalizer\SimpleNormalizer;

$memoizer = new Memoizer(
    normalizer: new SimpleNormalizer(),
    cache: new InMemoryCache(),
);
```

### Использование в классе

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

$calculator->sum(1, 2); // Вычисляет значение: 3
$calculator->sum(1, 2); // Возвращает закэшированное значение: 3

$calculator->sum(3, 4); // Вычисляет значение: 7
```

## Компоненты

### Memoizer

Основной класс для мемоизации. Принимает два параметра:
- `normalizer` - нормализатор для создания ключей кэша
- `cache` - реализация кэша

### Нормализаторы

#### SimpleNormalizer
Преобразует аргументы в строковый ключ с помощью стандартной PHP функции `serialize()`. Подходит для большинства случаев.

### Кэш

#### InMemoryCache
Хранит данные в памяти в течение времени выполнения скрипта.

## Кастомизация

Для кастомизации мемоизатора можно написать и использовать собственную реализацию нормализатора
(интерфейс `Kenny1911\Memoizer\Normalizer\Normalizer`) и (или) кеша (интерфейс `Kenny1911\Memoizer\Cache\Cache`).

## Рекомендации

1. **Используйте уникальные ключи** - включайте в ключ имя метода и все значимые параметры
2. **Избегайте мемоизации побочных эффектов** - мемоизация подходит только для чистых функций
3. **Учитывайте потребление памяти** - особенно при использовании InMemoryCache
4. **Тестируйте производительность** - убедитесь, что мемоизация действительно дает выигрыш

## Лицензия

MIT