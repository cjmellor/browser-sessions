<?php

namespace Cjmellor\BrowserSessions;

use Illuminate\Support\ServiceProvider;

class BrowserSessionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/browser-sessions.php' => config_path('browser-sessions.php'),
        ]);
    }

    public function register(): void
    {
        $this->app->singleton(
            abstract: 'browser-sessions',
            concrete: fn () => new BrowserSessions
        );
    }
}
