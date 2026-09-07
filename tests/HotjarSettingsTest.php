<?php

use JeffersonGoncalves\Hotjar\Facades\Hotjar;
use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

it('can resolve HotjarSettings from the container', function () {
    $settings = app(HotjarSettings::class);

    expect($settings)->toBeInstanceOf(HotjarSettings::class);
});

it('has correct default values', function () {
    $settings = app(HotjarSettings::class);

    expect($settings->site_id)->toBeNull()
        ->and($settings->version)->toBe(6);
});

it('can update and persist settings', function () {
    $settings = app(HotjarSettings::class);
    $settings->site_id = '1234567';
    $settings->version = 6;
    $settings->save();

    $fresh = app(HotjarSettings::class);

    expect($fresh->site_id)->toBe('1234567')
        ->and($fresh->version)->toBe(6);
});

it('belongs to the hotjar group', function () {
    expect(HotjarSettings::group())->toBe('hotjar');
});

it('can be accessed via the helper function', function () {
    $settings = hotjar_settings();

    expect($settings)->toBeInstanceOf(HotjarSettings::class);
});

it('resolves the underlying settings via the Facade', function () {
    expect(Hotjar::getFacadeRoot())->toBeInstanceOf(HotjarSettings::class);
});

it('reads a persisted value through the Facade', function () {
    $settings = app(HotjarSettings::class);
    $settings->site_id = '7654321';
    $settings->save();

    expect(Hotjar::getFacadeRoot()->site_id)->toBe('7654321');
});
