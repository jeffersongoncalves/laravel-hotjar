<?php

namespace JeffersonGoncalves\Hotjar\Settings;

use Spatie\LaravelSettings\Settings;

class HotjarSettings extends Settings
{
    public ?string $site_id;

    public int $version;

    public static function group(): string
    {
        return 'hotjar';
    }
}
