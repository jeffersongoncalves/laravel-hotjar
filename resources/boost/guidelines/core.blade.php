## Laravel Hotjar

### Overview
Laravel package that integrates Hotjar into Blade templates using `spatie/laravel-settings` for database-stored configuration. No config files -- all settings are managed via the `HotjarSettings` class and stored in the `settings` database table.

### Key Concepts
- **Settings-driven**: All configuration lives in `HotjarSettings` (group: `hotjar`), not in config files
- **Blade view**: Include `hotjar::script` in your layout to render the tracking script
- **Facade + Helper**: Access settings via `Hotjar` facade or `hotjar_settings()` helper
- **Auto-discovery**: Service provider is auto-discovered via `composer.json` extra.laravel.providers

### Settings (spatie/laravel-settings)

@verbatim
<code-snippet name="hotjar-settings-class" lang="php">
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
</code-snippet>
@endverbatim

### Configuration

Settings migration path: `database/settings/2026_09_07_000000_create_hotjar_settings.php`

Publish migrations:
@verbatim
<code-snippet name="publish-migrations" lang="bash">
php artisan vendor:publish --tag=hotjar-settings-migrations
</code-snippet>
@endverbatim

### Usage

Include the tracking script in your Blade layout (typically before `</head>`):
@verbatim
<code-snippet name="blade-include" lang="blade">
@include('hotjar::script')
</code-snippet>
@endverbatim

Access settings programmatically:
@verbatim
<code-snippet name="access-settings" lang="php">
// Via helper
$settings = hotjar_settings();
$settings->site_id = '1234567';
$settings->save();

// Via Facade
use JeffersonGoncalves\Hotjar\Facades\Hotjar;
$siteId = Hotjar::getFacadeRoot()->site_id;

// Via container
$settings = app(\JeffersonGoncalves\Hotjar\Settings\HotjarSettings::class);
</code-snippet>
@endverbatim

### Conventions
- Namespace: `JeffersonGoncalves\Hotjar`
- Service provider: `HotjarServiceProvider` extends `PackageServiceProvider` (spatie/laravel-package-tools)
- Settings group name: `hotjar`
- View namespace: `hotjar` (e.g., `hotjar::script`)
- The script tag only renders when `site_id` is not empty
- Tests use Pest with Orchestra Testbench and SQLite in-memory database
