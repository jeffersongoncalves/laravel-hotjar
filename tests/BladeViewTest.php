<?php

use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

it('renders the script tag when site_id is set', function () {
    $settings = app(HotjarSettings::class);
    $settings->site_id = '1234567';
    $settings->version = 6;
    $settings->save();

    $view = $this->blade('@include("hotjar::script")');

    $view->assertSee('https://static.hotjar.com/c/hotjar-', false)
        ->assertSee('hjid:1234567', false)
        ->assertSee('hjsv:6', false);
});

it('does not render the script tag when site_id is empty', function () {
    $settings = app(HotjarSettings::class);
    $settings->site_id = null;
    $settings->save();

    $view = $this->blade('@include("hotjar::script")');

    $view->assertDontSee('static.hotjar.com', false);
});
