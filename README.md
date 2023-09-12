[![Latest Version on Packagist](https://img.shields.io/packagist/v/cjmellor/browser-sessions?color=rgb%2856%20189%20248%29&label=release&style=for-the-badge)](https://packagist.org/packages/cjmellor/browser-sessions)
[![Total Downloads](https://img.shields.io/packagist/dt/cjmellor/browser-sessions.svg?color=rgb%28249%20115%2022%29&style=for-the-badge)](https://packagist.org/packages/cjmellor/browser-sessions)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/cjmellor/browser-sessions/php?color=rgb%28165%20180%20252%29&logo=php&logoColor=rgb%28165%20180%20252%29&style=for-the-badge)
![Laravel Version](https://img.shields.io/badge/laravel-^10-rgb(235%2068%2050)?style=for-the-badge&logo=laravel)

# Logout Other Browser Sessions

This package allows you to log out sessions that are active on other devices.

You may find this useful if you have logged in on a different device, or you have let someone else use your account, or you have forgotten to log out of a public computer. It can especially be useful if you see suspicious device activity on your account.

> **Note**
> 
> This code has been extracted from [Laravel Jetstream](https://jetstream.laravel.com) and cannot be used outside a Laravel application.

## Installation

You can install the package via composer:

```bash
composer require cjmellor/browser-sessions
```

## Usage

### Retrieving A User's Current Sessions

Use the `BrowserSessions` facade to retrieve all the current user's sessions:

```php
BrowserSessions::sessions();
```

This will return an object with some information about each session:

```php
[
  {
    "device": {
      "browser": "Safari",
      "desktop": true,
      "mobile": false,
      "platform": "OS X"
    },
    "ip_address": "127.0.0.1",
    "is_current_device": true,
    "last_active": "1 second ago"
  }
]
```

### Logging Out Other Browser Sessions

Use the `BrowserSessions` facade to log out all the user's other browser sessions:

```php
BrowserSessions::logoutOtherBrowserSessions();
```

> **Note**
> 
> A `password` must be sent along to the method to confirm the user's identity. Only then will the sessions be removed. See below on how you would implement this.

### Views

The package does not come with any pre-defined views to use. Here is an example though on how this could be implemented

In your `routes/web.php` file add the following route:

```php
Route::delete('logout-browser-sessions', function () {
    BrowserSessions::logoutOtherBrowserSessions();

    return back()->with('status', 'Logged out of other browser sessions.');
})->name('logout-browser-sessions');
```

Then in your view, you can add a form to submit a `DELETE` request to the above route:

```html
<form method="POST" action="{{ route('logout-browser-sessions') }}">
    @csrf
    @method('DELETE')
    
    <x-text-input label="Password" name="password" placeholder="Enter password" type="password" />
    
    <button class="btn btn-primary" type="submit">Logout Other Sessions</button>
</form>
```

## Credits

 - [Chris Mellor](https://github.com/cjmellor)

## License

The MIT Licence (MIT). Please see [Licence File](LICENSE) for more information.
