<?php

namespace App\Models;

use App\Models\Concerns\FlushesSitemapCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use FlushesSitemapCache;
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'price', 'old_price',
        'short_description', 'description', 'in_stock', 'is_new',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'int',
            'old_price' => 'int',
            'in_stock' => 'bool',
            'is_new' => 'bool',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('documents');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function priceFormatted(): string
    {
        return number_format($this->price, 0, '', ' ').' ₽';
    }

    public function oldPriceFormatted(): ?string
    {
        return $this->old_price ? number_format($this->old_price, 0, '', ' ').' ₽' : null;
    }
}
