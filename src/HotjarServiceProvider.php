<?php

namespace JeffersonGoncalves\Hotjar;

use Illuminate\Support\Facades\Config;
use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HotjarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-hotjar')
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        Config::set('settings.settings', array_merge(
            Config::get('settings.settings', []),
            [HotjarSettings::class]
        ));
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        $settingsMigrationsPath = __DIR__.'/../database/settings';

        Config::set('settings.migrations_paths', array_merge(
            [$settingsMigrationsPath],
            Config::get('settings.migrations_paths', [])
        ));

        $this->publishes([
            $settingsMigrationsPath => database_path('settings'),
        ], 'hotjar-settings-migrations');
    }
}
