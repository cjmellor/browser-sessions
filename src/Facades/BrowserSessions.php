<?php

namespace Cjmellor\BrowserSessions\Facades;

use Illuminate\Support\Facades\Facade;

class BrowserSessions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'browser-sessions';
    }
}
