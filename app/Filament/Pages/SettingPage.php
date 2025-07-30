<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Settings\GeneralSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SettingPage extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationLabel = "Configurations";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;
    public array $data = [];
    protected ?string $heading = "Configurez vos parametres";
    protected string $view = 'filament.pages.setting';

    public function mount(): void
    {

        $this->data = [
            'name' => app(GeneralSetting::class)->name,
            'phoneNumber' => app(GeneralSetting::class)->phoneNumber,
            'email' => app(GeneralSetting::class)->email,
            'support' => app(GeneralSetting::class)->support,
            'address' => app(GeneralSetting::class)->address,
            'companyNumber' => app(GeneralSetting::class)->companyNumber,
            'promotionalText' => app(GeneralSetting::class)->promotionalText,
            'facebookUrl' => app(GeneralSetting::class)->facebookUrl,
            'instagramUrl' => app(GeneralSetting::class)->instagramUrl,
            'twitterUrl' => app(GeneralSetting::class)->twitterUrl,
            'whatsappUrl' => app(GeneralSetting::class)->whatsappUrl,
            'mapLink' => app(GeneralSetting::class)->mapLink,
        ];
    }

    public function form(Schema $schema): Schema
    {
        $socialeSchemas = [];
        foreach (['facebookUrl', 'instagramUrl', 'twitterUrl', 'whatsappUrl'] as $key => $link) {
            $socialeSchemas[] = TextInput::make($link)->label($link)->translateLabel()->required();
        }
        return $schema->schema([
            Section::make("Parametre generaux")->schema([
                Textarea::make('promotionalText')
                    ->label("Texte promotionelle")
                    ->required()->columnSpanFull(),
                TextInput::make('name')->label("Nom"),
                TextInput::make('email')->label("Email")->email(),
                TextInput::make('support')->label("Email de support")->email(),
                TextInput::make('address')->translateLabel(),
                TextInput::make('phoneNumber')->translateLabel(),
                TextInput::make('companyNumber')->translateLabel(),
                TextInput::make('mapLink')->translateLabel()->url()->prefixIcon(Heroicon::Link),
            ])->columns(2)->collapsible(),
            Section::make("Liens sociaux")->schema([
                ...$socialeSchemas
            ])->columns(2)

        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label("sauvegarder")
                ->action(function () {
                    $this->form->validate();
                    foreach ($this->data as $key => $item) {
                        Setting::updateOrCreate([
                            'name' => $key,
                            'group' => GeneralSetting::group(),
                        ], [
                            'payload' => $item
                        ]);
                    }
                    Notification::make()
                        ->title('Success !')
                        ->success()
                        ->body('Information  mis a jour avec success.')->send();
                })
        ];
    }

}
