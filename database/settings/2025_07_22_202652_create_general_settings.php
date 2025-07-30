<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.promotionalText',config('project.promotional_text'));
        $this->migrator->add('general.name',config('project.about.name'));
        $this->migrator->add('general.email',config('project.about.email'));
        $this->migrator->add('general.phoneNumber',config('project.about.phone_number'));
        $this->migrator->add('general.support',config('project.about.support'));
        $this->migrator->add('general.companyNumber',config('project.about.company_number'));
        $this->migrator->add('general.address',config('project.about.address'));
        $this->migrator->add('general.mapLink',config('project.about.mapLink'));
        //sociale link
        $this->migrator->add('general.facebookUrl',config('project.socials.facebook'));
        $this->migrator->add('general.instagramUrl',config('project.socials.instagram'));
        $this->migrator->add('general.whatsappUrl',config('project.socials.whatsapp'));
        $this->migrator->add('general.twitterUrl',config('project.socials.twitter'));
    }
};
