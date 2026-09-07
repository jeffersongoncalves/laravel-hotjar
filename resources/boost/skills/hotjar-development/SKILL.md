---
name: hotjar-development
description: Development skill for the laravel-hotjar package -- Hotjar integration for Laravel using spatie/laravel-settings
---

## When to use this skill

- Adding or modifying Hotjar tracking behavior
- Working with the `HotjarSettings` class or its properties
- Updating the Blade script view (`hotjar::script`)
- Writing tests for the laravel-hotjar package

## Setup

### Requirements
- PHP 8.2+
- Laravel 11, 12, or 13
- `spatie/laravel-settings` ^3.0
- `spatie/laravel-package-tools` ^1.14.0

### Installation
```bash
composer require jeffersongoncalves/laravel-hotjar
php artisan vendor:publish --tag=hotjar-settings-migrations
php artisan migrate
```

### Package structure
```
laravel-hotjar/
├── src/
│   ├── HotjarServiceProvider.php    # Package service provider
│   ├── Facades/Hotjar.php           # Facade for HotjarSettings
│   ├── Settings/HotjarSettings.php  # Settings class (spatie/laravel-settings)
│   └── helpers.php                  # hotjar_settings() helper function
├── database/
│   └── settings/
│       └── 2026_09_07_000000_create_hotjar_settings.php
├── resources/
│   └── views/
│       └── script.blade.php         # Hotjar tracking script template
└── tests/
    ├── TestCase.php                 # Base test case with SQLite setup
    ├── Pest.php                     # Pest configuration
    ├── HotjarSettingsTest.php       # Settings unit tests
    └── BladeViewTest.php            # Blade view rendering tests
```

## Features

### HotjarSettings class

The core settings class extends `Spatie\LaravelSettings\Settings` with group `hotjar`:

```php
namespace JeffersonGoncalves\Hotjar\Settings;

use Spatie\LaravelSettings\Settings;

class HotjarSettings extends Settings
{
    public ?string $site_id;  // Hotjar site ID (hjid)
    public int $version;      // Hotjar tracking script version (hjsv, default: 6)

    public static function group(): string
    {
        return 'hotjar';
    }
}
```

### Settings defaults (from migration)

| Property  | Default | Description                          |
|-----------|---------|---------------------------------------|
| `site_id` | `null`  | Hotjar site ID (`hjid`)                |
| `version` | `6`     | Hotjar tracking script version (`hjsv`)|

### Accessing settings

```php
// Helper function (globally available)
$settings = hotjar_settings();

// Via Laravel container
$settings = app(\JeffersonGoncalves\Hotjar\Settings\HotjarSettings::class);

// Update and persist
$settings->site_id = '1234567';
$settings->save();
```

### Blade view rendering

Include in your layout's `<head>`:

```blade
@include('hotjar::script')
```

The view renders the official Hotjar tracking snippet with `hjid`/`hjsv` filled from settings. It only renders when `site_id` is not empty.

### Service provider

`HotjarServiceProvider` extends `PackageServiceProvider` from spatie/laravel-package-tools:

```php
// Registers the package with views
$package->name('laravel-hotjar')->hasViews();

// Automatically registers HotjarSettings in spatie/laravel-settings config
Config::set('settings.settings', array_merge(
    Config::get('settings.settings', []),
    [HotjarSettings::class]
));

// Publishes settings migrations with tag 'hotjar-settings-migrations'
$this->publishes([
    $settingsMigrationsPath => database_path('settings'),
], 'hotjar-settings-migrations');
```

### Facade

The `Hotjar` facade resolves to `HotjarSettings::class`:

```php
use JeffersonGoncalves\Hotjar\Facades\Hotjar;

Hotjar::getFacadeRoot(); // returns HotjarSettings instance
```

## Configuration

This package uses **no config files**. All configuration is stored in the database via `spatie/laravel-settings`.

```bash
php artisan vendor:publish --tag=hotjar-settings-migrations
php artisan migrate
```

## Testing patterns

Tests use **Pest** with **Orchestra Testbench**. The base `TestCase` sets up:
- SQLite in-memory database
- `settings` table schema (id, group, name, locked, payload, timestamps)
- Default seed values matching the migration defaults

### Running tests

```bash
vendor/bin/pest
vendor/bin/pest --coverage
vendor/bin/phpstan analyse
vendor/bin/pint
```
