<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?string $name = '';

    public ?string $about = '';

    public ?string $faskes = '';

    public ?string $address = '';

    public ?string $logo = null;

    public ?string $juknis = null;

    public ?bool $show_logo = true;

    public static function group(): string
    {
        return 'general';
    }
}
