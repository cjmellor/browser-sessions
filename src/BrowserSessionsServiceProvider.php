<?php

namespace Cjmellor\BrowserSessions;

use Illuminate\Support\ServiceProvider;

class BrowserSessionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register(): void
    {
        $this->app->singleton(
            abstract: 'browser-sessions',
            concrete: fn () => new BrowserSessions()
        );
    }
}
