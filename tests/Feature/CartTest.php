<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('добавляет товар в корзину и суммирует количество', function () {
    $product = Product::factory()->create();

    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'qty' => 2])
        ->assertOk()
        ->assertJson(['count' => 2]);

    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'qty' => 1])
        ->assertOk()
        ->assertJson(['count' => 3]);
});

it('отклоняет неизвестные товары и некорректное количество', function () {
    $product = Product::factory()->create();

    $this->postJson(route('cart.store'), ['product_id' => 999999, 'qty' => 1])
        ->assertUnprocessable();

    $this->postJson(route('cart.store'), ['product_id' => $product->id, 'qty' => 0])
        ->assertUnprocessable();
});
