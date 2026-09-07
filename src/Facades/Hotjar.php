<?php

namespace JeffersonGoncalves\Hotjar\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Hotjar\Settings\HotjarSettings;

/**
 * @property ?string $site_id
 * @property int $version
 *
 * @see HotjarSettings
 */
class Hotjar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return HotjarSettings::class;
    }
}
