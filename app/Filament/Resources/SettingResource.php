<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\SettingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key'),
                TextColumn::make('type'),
                TextInputColumn::make('value')
                ->rules(function ($record) {
                    $type = $record->type ?? null;

                    // Tentukan aturan validasi berdasarkan nilai type
                    return match ($type) {
                        'number' => ['required', 'numeric'], // Validasi angka
                        'string' => ['required', 'string'],  // Validasi string
                        'boolean' => ['required', 'boolean'], // Validasi boolean
                        'json' => ['required', 'json'],      // Validasi JSON
                        default => ['required'],             // Default rule
                    };
                })
                ->placeholder('Masukkan nilai sesuai tipe'),
                TextColumn::make('desc')
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            // 'create' => Pages\CreateSetting::route('/create'),
            // 'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
