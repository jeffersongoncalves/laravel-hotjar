<?php

use Illuminate\Support\Facades\Vite;
use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

it('stamps the CSP nonce on every script tag', function () {
    Vite::useCspNonce('test-nonce');
    $settings = app(HotjarSettings::class);
    $settings->site_id = '1234567';
    $settings->version = 6;
    $settings->save();
    $html = (string) $this->blade('@include("hotjar::script")');

    preg_match_all('/<script\b[^>]*>/', $html, $tags);

    expect($tags[0])->not->toBeEmpty()->each->toContain('nonce="test-nonce"');
});

it('renders no nonce attribute when the app uses none', function () {
    $settings = app(HotjarSettings::class);
    $settings->site_id = '1234567';
    $settings->version = 6;
    $settings->save();
    $html = (string) $this->blade('@include("hotjar::script")');

    expect($html)->toContain('<script')->not->toContain('nonce=');
});
