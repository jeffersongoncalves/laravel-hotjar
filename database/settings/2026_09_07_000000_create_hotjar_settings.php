<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('hotjar.site_id', null);
        $this->migrator->add('hotjar.version', 6);
    }
};
