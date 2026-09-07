<?php

use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

if (! function_exists('hotjar_settings')) {
    function hotjar_settings(): HotjarSettings
    {
        return app(HotjarSettings::class);
    }
}
