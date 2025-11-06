<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-c-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
            ->label('Nama')
            ->required()
            ->maxLength(255)
            ->columnSpan([
                'default' => 1,
            ]),
            TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255)
            ->columnSpan([
                'default' => 1,
            ]),
            
        TextInput::make('password')
            ->password()
            // hanya ikut disimpan kalau ada isian (mencegah overwrite null)
            ->dehydrated(fn ($state) => filled($state))
            // hash setiap kali ada isian
            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
            // wajib kalau di halaman Create, opsional kalau Edit
            ->required(fn ($livewire) => $livewire instanceof CreateRecord)
            // ubah label tergantung Create/Edit
            ->label(fn ($livewire) => $livewire instanceof CreateRecord
                ? 'Password'
                : 'Password (isi jika ingin ganti)'),
            Hidden::make('email_verified_at')
            ->default(fn (string $operation) => $operation === 'create' ? now() : null)
            ->dehydrated(fn (string $operation, $state) => $operation === 'create' && filled($state)),
            Select::make('roles')
            ->relationship('roles', 'name')
            ->multiple()
            ->preload()
            ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
