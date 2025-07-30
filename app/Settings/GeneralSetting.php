<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{

    public string $name = '';
    public string $phoneNumber = '';
    public string $email = '';
    public string $support = '';
    public string $address = '';
    public string $companyNumber = '';
    public string $promotionalText = '';
    public string $facebookUrl = '';
    public string $twitterUrl = '';
    public string $instagramUrl = '';
    public string $whatsappUrl = '';
    public string $mapLink = '';

    public static function group(): string
    {
        return 'general';
    }
}
