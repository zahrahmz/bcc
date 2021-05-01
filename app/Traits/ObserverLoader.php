<?php


namespace App\Traits;

use App\Observers\BaseObserver;

trait ObserverLoader
{
    public static function bootObserverLoader()
    {
        static::observe(BaseObserver::class);
    }
}
