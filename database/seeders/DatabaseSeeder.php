<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $leaves = $this->seedCategories();
        $this->seedProducts($leaves, $this->seedAttributes());
        $this->seedBlog();
    }

    private function seedCategories(): array
    {
        $leaves = [];

        foreach (range(1, 4) as $i) {
            $root = Category::create([
                'name' => 'Название',
                'slug' => "category-{$i}",
                'description' => 'Описание категории',
            ]);

            foreach (range(1, 2) as $j) {
                $leaves[] = Category::create([
                    'parent_id' => $root->id,
                    'name' => 'Название',
                    'slug' => "category-{$i}-{$j}",
                    'description' => 'Описание категории',
                ]);
            }
        }

        return $leaves;
    }

    private function seedAttributes(): array
    {
        $groups = [
            'checkbox' => ['Фильтр', Attribute::TYPE_CHECKBOX, true, [
                'Земляничный нектар', 'Хвойный экстракт', 'Кленовый сироп', 'Берёзовый сок',
                'Облепиховый морс', 'Рябиновый настой', 'Черничный кисель', 'Брусничный компот',
            ]],
            'radio' => ['Фильтр', Attribute::TYPE_RADIO, true, [
                'Вишнёвый нектар', 'Сосновый сироп', 'Липовый нектар', 'Осиновый экстракт',
                'Можжевёловый морс', 'Клюквенный настой', 'Ежевичный кисель', 'Малиновый компот',
            ]],
            'select' => ['Свойство', Attribute::TYPE_SELECT, false, [
                'Тёмно-серый', 'Светло-серый', 'Чёрный',
            ]],
        ];

        $values = [];

        foreach ($groups as $key => [$name, $type, $filterable, $items]) {
            $attribute = Attribute::create([
                'name' => $name,
                'slug' => "filter-{$key}",
                'type' => $type,
                'is_filterable' => $filterable,
                'sort_order' => count($values),
            ]);

            foreach ($items as $sort => $item) {
                $values[$key][] = $attribute->values()->create([
                    'value' => $item,
                    'slug' => Str::slug($item),
                    'sort_order' => $sort,
                ]);
            }
        }

        foreach (range(1, 4) as $i) {
            $spec = Attribute::create([
                'name' => 'Характеристика',
                'slug' => "spec-{$i}",
                'type' => Attribute::TYPE_SPEC,
                'is_filterable' => false,
                'sort_order' => 10 + $i,
            ]);

            $values['spec'][] = $spec->values()->create(['value' => 'Значение', 'slug' => 'znachenie']);
        }

        return $values;
    }

    private function seedProducts(array $leaves, array $values): void
    {
        foreach ($leaves as $leaf) {
            Product::factory()
                ->count(8)
                ->for($leaf, 'category')
                ->create()
                ->each(function (Product $product) use ($values) {
                    $product->attributeValues()->attach([
                        fake()->randomElement($values['checkbox'])->id,
                        fake()->randomElement($values['radio'])->id,
                        fake()->randomElement($values['select'])->id,
                        ...collect($values['spec'])->pluck('id'),
                    ]);
                });
        }
    }

    private function seedBlog(): void
    {
        $tags = collect(range(1, 3))
            ->map(fn (int $i) => Tag::create(['name' => "Тег {$i}", 'slug' => "tag-{$i}"]));

        Post::factory()
            ->count(12)
            ->create()
            ->each(fn (Post $post) => $post->tags()->attach(
                $tags->random(rand(1, 2))->pluck('id'),
            ));
    }
}
