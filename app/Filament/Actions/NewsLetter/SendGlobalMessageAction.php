<?php

namespace App\Filament\Actions\NewsLetter;

use App\Mail\NewsLetterMail;
use App\Models\Subscriber;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Mail;

class SendGlobalMessageAction
{
    public static function make(): Action
    {
        return Action::make("global_message")->label("Envoyer un message")
            ->icon(Heroicon::OutlinedEnvelope)
            ->schema([
                Select::make('subscribers')->searchable()->multiple()->options(fn()=>Subscriber::pluck(column: 'email',key: 'id'))->columnSpanFull(),
                MarkdownEditor::make('message')->required()->columnSpanFull()
            ])
            ->action(function ($data){
                $subscribers = Subscriber::query()->whereIn('id',$data['subscribers'])->get();
                Mail::to($subscribers)->send(new NewsLetterMail($data['message']));
            });
    }
}
