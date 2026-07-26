<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('сохраняет заявку из модальной формы', function () {
    $this->post(route('lead.store'), [
        'name' => 'Константин',
        'phone' => '+7 900 000-00-00',
        'message' => 'Вопрос по дому',
        'consent' => '1',
    ])->assertRedirect();

    $this->assertDatabaseHas('leads', ['name' => 'Константин']);
});
