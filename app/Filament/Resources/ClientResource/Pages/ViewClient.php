<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Tabs::make('ClientTabs')
                    ->tabs([
                        Infolists\Components\Tabs\Tab::make('البيانات الأساسية')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('الاسم'),

                                Infolists\Components\TextEntry::make('type')
                                    ->label('النوع'),

                                Infolists\Components\TextEntry::make('city')
                                    ->label('المدينة'),

                                Infolists\Components\TextEntry::make('address')
                                    ->label('العنوان'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label('البريد الإلكتروني'),

                                Infolists\Components\TextEntry::make('username')
                                    ->label('اسم المستخدم'),

                                Infolists\Components\TextEntry::make('start_at')
                                    ->label('تاريخ البداية')
                                    ->date(),

                                Infolists\Components\TextEntry::make('end_at')
                                    ->label('تاريخ النهاية')
                                    ->date(),
                            ])
                            ->columns(2),

                        Infolists\Components\Tabs\Tab::make('الملاحظات')
                            ->schema([
                                Infolists\Components\TextEntry::make('note')
                                    ->label('الملاحظات')
                                    ->default('-'),
                            ]),
                    ]),
            ]);
    }
}
