<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use NodeTrait;

    public const string CACHE_ROOTS = 'categories.roots';

    protected $fillable = [
        'parent_id', 'name', 'slug', 'description', 'meta_title', 'meta_description',
    ];

    protected static function booted(): void
    {
        $flush = function (): void {
            cache()->forget(self::CACHE_ROOTS);
            cache()->forget('sitemap');
        };

        static::saved($flush);
        static::deleted($flush);
    }

    public static function cachedRoots(): array
    {
        return cache()->remember(
            self::CACHE_ROOTS,
            now()->addHour(),
            fn () => static::query()->whereIsRoot()->with('media')->defaultOrder()->get()
                ->map(fn (self $category) => [
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image' => $category->getFirstMediaUrl('image') ?: null,
                ])->all(),
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
