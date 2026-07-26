<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('возвращает успешный ответ на главной странице', function () {
    $this->get('/')->assertOk();
});
