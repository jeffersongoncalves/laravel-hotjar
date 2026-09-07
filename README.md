<div class="filament-hidden">

![Laravel Hotjar](https://raw.githubusercontent.com/jeffersongoncalves/laravel-hotjar/master/art/jeffersongoncalves-laravel-hotjar.png)

</div>

# Laravel Hotjar

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-hotjar.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-hotjar)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-hotjar/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-hotjar/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-hotjar.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-hotjar)

This Laravel package seamlessly integrates Hotjar into your Blade templates. Easily capture heatmaps, session recordings, and feedback directly within your Laravel application, providing valuable insights into your website's user experience. This package simplifies the integration process, saving you time and effort. With minimal configuration, you can leverage Hotjar's powerful behavior analytics features to gain a clearer understanding of your audience and website usage.

Settings are stored in the database using [spatie/laravel-settings](https://github.com/spatie/laravel-settings), allowing you to manage them dynamically (e.g., via an admin panel) without relying on `.env` files.

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-hotjar
```

Publish and run the settings migration:

```bash
php artisan vendor:publish --tag=hotjar-settings-migrations
php artisan migrate
```

## Configuration

All settings are managed exclusively from the database after running the migration. You can update them programmatically:

```php
use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

$settings = app(HotjarSettings::class);
$settings->site_id = '1234567';
$settings->save();
```

Or use the helper function:

```php
$settings = hotjar_settings();
$settings->site_id = '1234567';
$settings->save();
```

Or use the Facade. The facade resolves the underlying `HotjarSettings` instance, so read or write properties through `getFacadeRoot()`:

```php
use JeffersonGoncalves\Hotjar\Facades\Hotjar;

// Read a value
$siteId = Hotjar::getFacadeRoot()->site_id;

// Update and persist
$settings = Hotjar::getFacadeRoot();
$settings->site_id = '1234567';
$settings->save();
```

### Available settings

| Setting   | Type      | Default | Description                                            |
|-----------|-----------|---------|---------------------------------------------------------|
| `site_id` | `?string` | `null`  | Your Hotjar site ID (`hjid`). The script only renders when this is set. |
| `version` | `int`     | `6`     | Hotjar tracking script version (`hjsv`).                |

## Usage

Add the Hotjar script to your Blade layout (typically in `<head>`):

```php
@include('hotjar::script')
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Goncalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
