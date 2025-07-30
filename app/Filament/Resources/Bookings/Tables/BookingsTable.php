<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Domain\Enums\BookingStatusEnum;
use App\Models\Accommodation;
use App\Models\AccommodationType;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('start_date')->translateLabel()->date()->sortable(),
                TextColumn::make('end_date')->date()->sortable()->translateLabel(),
                TextColumn::make('email')->searchable()->translateLabel(),
                TextColumn::make('name')->searchable()->translateLabel(),
                TextColumn::make('status')->badge(),
                TextColumn::make('accommodation.accommodationType.name'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //select filter for accomodation types
                \Filament\Tables\Filters\SelectFilter::make('accommodationType')
                    ->relationship('accommodation.accommodationType','name')
                    ->preload()
                    ->label('Accommodation Type')
                    ->searchable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    //approved action
                    \Filament\Actions\Action::make('approve')
                        ->action(function ($record) {
                            $record->update(['status' => BookingStatusEnum::APPROVED]);
                        })
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->hidden(fn($record) => $record->status !== BookingStatusEnum::PENDING),
                    //cancel action with confirmation
                    \Filament\Actions\Action::make('cancel')
                        ->action(function ($record) {
                            $record->update(['status' => BookingStatusEnum::CANCELLED]);
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->hidden(fn($record) => $record->status !== BookingStatusEnum::PENDING),
                    EditAction::make(),
                ]),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function ($query) {
                return $query->with('accommodation')->withCasts(['status'=>BookingStatusEnum::class]);
            });
    }
}
