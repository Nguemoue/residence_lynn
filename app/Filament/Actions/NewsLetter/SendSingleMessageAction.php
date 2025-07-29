<?php

namespace App\Filament\Actions\NewsLetter;

use App\Mail\NewsLetterMail;
use App\Models\Subscriber;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class SendSingleMessageAction
{
    public static function make(): Action
    {
        return Action::make("global_message")->label("Envoyer un message")
            ->icon(Heroicon::OutlinedEnvelope)
            ->schema([
                MarkdownEditor::make('message')->required()->columnSpanFull()
            ])
            ->action(function (Subscriber $record, array $data) {
                Mail::to($record)->send(new NewsLetterMail($data['message']));
            });
    }
}
