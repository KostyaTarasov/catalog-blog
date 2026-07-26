<?php

namespace App\Models;

use App\Models\Concerns\FlushesSitemapCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use FlushesSitemapCache;
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'lead', 'content', 'published_at', 'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
