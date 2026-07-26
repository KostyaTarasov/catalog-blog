<?php

namespace App\Models\Concerns;

trait FlushesSitemapCache
{
    public static function bootFlushesSitemapCache(): void
    {
        $flush = fn () => cache()->forget('sitemap');

        static::saved($flush);
        static::deleted($flush);
    }
}
