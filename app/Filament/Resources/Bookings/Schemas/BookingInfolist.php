<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Booking Overview')
                    ->description('General information about the booking')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('start_date')
                                    ->label('Check-in Date')
                                    ->date('d M Y')
                                    ->columnSpan(1)
                                    ->icon('heroicon-o-calendar')
                                    ->color('primary')
                                    ->weight('bold'),
                                TextEntry::make('end_date')
                                    ->label('Check-out Date')
                                    ->date('d M Y')
                                    ->columnSpan(1)
                                    ->icon('heroicon-o-calendar')
                                    ->color('primary')
                                    ->weight('bold'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Guest Email')
                                    ->icon('heroicon-o-envelope')
                                    ->color('info')
                                    ->url(fn ($record) => "mailto:{$record->email}")
                                    ->openUrlInNewTab(),
                                TextEntry::make('phone')
                                    ->label('Guest Phone')
                                    ->icon('heroicon-o-phone')
                                    ->color('info')
                                    ->url(fn ($record) => "tel:{$record->phone}")
                                    ->openUrlInNewTab(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Guest Name')
                                    ->icon('heroicon-o-user')
                                    ->color('success')
                                    ->weight('bold'),
                                TextEntry::make('guest_number')
                                    ->label('Number of Guests')
                                    ->icon('heroicon-o-users')
                                    ->color('success')
                                    ->weight('bold')
                                    ->suffix(' guests'),
                            ]),
                    ])
                    ->collapsible()
                    ->compact()
                    ->headerActions([
                        // Optional action (e.g., edit or cancel) can be added here
                    ])
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200',
                    ]),

                Section::make('Booking Status & Identifiers')
                    ->description('Status and related IDs')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->color(fn (string $state): string => match ($state) {
                                'confirmed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'confirmed' => 'heroicon-o-check-circle',
                                'pending' => 'heroicon-o-clock',
                                'cancelled' => 'heroicon-o-x-circle',
                                default => 'heroicon-o-question-mark-circle',
                            })
                            ->size('lg'),
                        TextEntry::make('accommodation.code')
                            ->label('Accommodation Code')
                            ->icon('heroicon-o-home')
                            ->color('secondary')
                            ->weight('medium')
                            ->url(fn ($record) => route('accommodations.show', $record->accommodation->id))
                            ->openUrlInNewTab(),
                        TextEntry::make('accommodation.type.name')
                            ->label('Accommodation Type')
                            ->icon('heroicon-o-building-office')
                            ->color('secondary')
                            ->weight('medium'),
                        TextEntry::make('user_id')
                            ->label('User ID')
                            ->icon('heroicon-o-user-group')
                            ->color('secondary')
                            ->weight('medium'),
                    ])
                    ->collapsible()
                    ->compact()
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200 mt-6',
                    ]),

                Section::make('User Information')
                    ->description('Details of the booking user')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User Name')
                            ->icon('heroicon-o-user-circle')
                            ->color('info')
                            ->weight('bold'),
                        TextEntry::make('user.email')
                            ->label('User Email')
                            ->icon('heroicon-o-envelope')
                            ->color('info')
                            ->url(fn ($record) => "mailto:{$record->user->email}")
                            ->openUrlInNewTab(),
                    ])
                    ->collapsible()
                    ->compact()
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200 mt-6',
                    ]),

                Section::make('Timestamps')
                    ->description('Creation and update dates')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-clock')
                            ->color('gray')
                            ->weight('medium'),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-refresh')
                            ->color('gray')
                            ->weight('medium'),
                    ])
                    ->collapsible()
                    ->compact()
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200 mt-6',
                    ]),
            ])
            ->columns(1);
    }
}
