<?php

namespace App\Filament\Dashboard\Resources\Bookings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Booking Summary')
                    ->description('Overview of your booking details')
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
                                    ->label('Your Email')
                                    ->icon('heroicon-o-envelope')
                                    ->color('info')
                                    ->url(fn ($record) => "mailto:{$record->email}")
                                    ->openUrlInNewTab(),
                                TextEntry::make('phone')
                                    ->label('Your Phone')
                                    ->icon('heroicon-o-phone')
                                    ->color('info')
                                    ->url(fn ($record) => "tel:{$record->phone}")
                                    ->openUrlInNewTab(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Booked By')
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
                        // Optional action (e.g., cancel booking) can be added here
                    ])
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200',
                    ]),

                Section::make('Accommodation Details')
                    ->description('Information about your booked accommodation')
                    ->schema([
                        TextEntry::make('accommodation.code')
                            ->label('Accommodation Code')
                            ->icon('heroicon-o-home')
                            ->color('secondary')
                            ->weight('medium')
                            ->url(fn ($record) => route('accommodations.show', $record->accommodation->id))
                            ->openUrlInNewTab(),
                        TextEntry::make('accommodation.accommodationType.name')
                            ->label('Accommodation Type')
                            ->icon('heroicon-o-building-office')
                            ->color('secondary')
                            ->weight('medium'),
                    ])
                    ->collapsible()
                    ->compact()
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200 mt-6',
                    ]),

                Section::make('Booking Status')
                    ->description('Current status of your booking')
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
                    ])
                    ->collapsible()
                    ->compact()
                    ->extraAttributes([
                        'class' => 'bg-base-100 shadow-lg rounded-lg p-6 border border-gray-200 mt-6',
                    ]),

                Section::make('User Information')
                    ->description('Your account details associated with this booking')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Your Name')
                            ->icon('heroicon-o-user-circle')
                            ->color('info')
                            ->weight('bold'),
                        TextEntry::make('user.email')
                            ->label('Your Email')
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

                Section::make('Booking Timestamps')
                    ->description('Creation and update dates of the booking')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Booked At')
                            ->dateTime('d M Y, H:i')
                            ->icon('heroicon-o-clock')
                            ->color('gray')
                            ->weight('medium'),
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
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
