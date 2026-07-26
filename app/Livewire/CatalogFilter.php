<?php

namespace App\Livewire;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogFilter extends Component
{
    use WithPagination;

    public Category $category;

    #[Url(except: '')]
    public string $sort = '';

    #[Url(except: 25)]
    public int $perPage = 25;

    #[Url(except: '')]
    public string $priceFrom = '';

    #[Url(except: '')]
    public string $priceTo = '';

    #[Url(except: [])]
    public array $values = [];

    #[Url(except: '')]
    public string $radio = '';

    public const array PER_PAGE_OPTIONS = [25, 50, 100];

    public const array SORT_OPTIONS = [
        '' => 'По умолчанию',
        'price_asc' => 'Сначала дешевле',
        'price_desc' => 'Сначала дороже',
    ];

    public function mount(Category $category): void
    {
        $this->category = $category;
    }

    public function updated(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        [$priceMin, $priceMax] = $this->priceBounds();

        return view('livewire.catalog-filter', [
            'filters' => Attribute::query()
                ->where('is_filterable', true)
                ->with('values')
                ->orderBy('sort_order')
                ->get(),
            'products' => $this->products(),
            'priceMin' => $priceMin,
            'priceMax' => $priceMax,
        ]);
    }

    private ?array $categoryIds = null;

    private function baseQuery(): Builder
    {
        $this->categoryIds ??= $this->category->descendants()
            ->pluck('id')
            ->push($this->category->id)
            ->all();

        return Product::query()->whereIn('category_id', $this->categoryIds);
    }

    private function priceBounds(): array
    {
        $row = $this->baseQuery()->selectRaw('min(price) as min_price, max(price) as max_price')->first();

        return [(int) $row->min_price, (int) $row->max_price];
    }

    private function products(): LengthAwarePaginator
    {
        $query = $this->baseQuery()->with('media');

        if ($this->priceFrom !== '') {
            $query->where('price', '>=', (int) $this->priceFrom);
        }

        if ($this->priceTo !== '') {
            $query->where('price', '<=', (int) $this->priceTo);
        }

        $selected = array_filter([...$this->values, $this->radio]);

        if ($selected !== []) {
            AttributeValue::query()
                ->whereIn('slug', $selected)
                ->get(['id', 'attribute_id'])
                ->groupBy('attribute_id')
                ->each(fn ($group) => $query->whereHas(
                    'attributeValues',
                    fn (Builder $q) => $q->whereIn('attribute_values.id', $group->pluck('id')),
                ));
        }

        match ($this->sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            default => $query->latest(),
        };

        return $query->paginate($this->perPage);
    }
}
