<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Название',
            'slug' => 'category-'.fake()->unique()->numberBetween(1, 100000),
            'description' => 'Описание категории',
        ];
    }
}
