<?php

namespace App\Services;

class Cart
{
    private const string KEY = 'cart';

    private const int MAX_QTY = 99;

    public function items(): array
    {
        return session(self::KEY, []);
    }

    public function add(int $productId, int $qty = 1): void
    {
        $items = $this->items();
        $items[$productId] = min(($items[$productId] ?? 0) + $qty, self::MAX_QTY);

        session([self::KEY => $items]);
    }

    public function count(): int
    {
        return array_sum($this->items());
    }
}
