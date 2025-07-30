<?php

namespace App\Filament\Dashboard\Resources\Bookings\Tables;

use App\Domain\Enums\BookingStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('start_date')->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')->translateLabel()
                    ->date()
                    ->sortable(),
                TextColumn::make('guest_number')->translateLabel()
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                TextColumn::make('accommodation.accommodationType.name')->translateLabel(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                //cancel action with confirmation
                \Filament\Actions\Action::make('cancel')
                    ->action(function ($record) {
                        $record->update(['status' => BookingStatusEnum::CANCELLED]);
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->hidden(fn($record) => $record->status !== BookingStatusEnum::PENDING),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function ($query) {
                return $query->with('accommodation')->where('user_id',Filament::auth()->id())->withCasts(['status' => BookingStatusEnum::class]);
            });
    }
}
