<?php

declare(strict_types=1);

namespace App\Trait;

trait MapTrait
{
    /**
     * @template T
     *
     * @param iterable<T>                   $collection
     * @param callable(T $item): int|string $keyProvider
     *
     * @return array<string|int, T>
     */
    public function createMap(iterable $collection, callable $keyProvider): array
    {
        $items = [];
        foreach ($collection as $item) {
            $items[$keyProvider($item)] = $item;
        }

        return $items;
    }
}
