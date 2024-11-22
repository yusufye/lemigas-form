<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Code;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Crypt;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\ViewEntry;
use App\Filament\Resources\CodeResource\Pages;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CodeResource\RelationManagers;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class CodeResource extends Resource
{
    protected static ?string $model = Code::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string $view = 'filament.resources.codes.pages.generate-code-url.blade';
    // protected static ?string $modelLabel = 'Generate Code';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')->required()->unique(modifyRuleUsing: function (Unique $rule) {
                    return $rule->where('created_by',auth()->id());
                })->numeric()->rules(['digits_between:1,15'])
            ]);
    }

    public static function table(Table $table): Table
    {
        
        // $url=$record->code;
        return $table
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('code')
                ->label('Code')
                ->badge()
                ->searchable()
                ->sortable()
                ->copyable()
                ->copyableState(fn (Code $record) => url('public/'.Crypt::encryptString($record->id)))->copyMessage('Link Copied'),
                //->copyableState(fn (Code $record) => Crypt::encryptString($record->id))->copyMessage('Encrypted ID Copied'),

                TextColumn::make('user_created.name')
                ->label('User')
                ->sortable()
                ->searchable(),
                TextColumn::make('publicForm.submitted_at')
                ->label('Submitted At')
                ->sortable()
                ->dateTime(),
                ToggleColumn::make('is_active')
                ->label('Active')
                ->sortable()
                ->visible(auth()->user()->hasRole('super_admin'))
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                if (!auth()->user()->hasRole('super_admin')) {
                    return $query->where(['created_by'=>auth()->id(),'is_active'=>1]);
                }
            })
            ->filters([
                SelectFilter::make('user_created') 
                ->relationship('user_created', 'name')
                ->label('User')
                ->visible(auth()->user()->hasRole('super_admin')),
                DateRangeFilter::make('publicForm')
                ->modifyQueryUsing(function (Builder $query, ?Carbon $startDate, ?Carbon $endDate, $dateString) {
                    return $query->when(!empty($dateString), function (Builder $query) use ($startDate, $endDate) {
                        return $query->whereHas('publicForm', function (Builder $query) use ($startDate, $endDate) {
                            $query->whereBetween('submitted_at', [$startDate, $endDate]);
                        });
                    });
                }),
                SelectFilter::make('submitted_at')
                ->options([
                    'submitted' => 'Submitted',
                    'unsubmitted' => 'Unsubmitted',
                ])
                ->label('Submit Status')
                ->query(
                    fn (array $data, Builder $query): Builder =>
                    $query->when(
                        $data['value'],
                        function (Builder $query) use ($data) {
                            if ($data['value'] === 'submitted') {
                                $query->whereHas('publicForm', function (Builder $query) {
                                    $query->whereNotNull('submitted_at');
                                });
                            } elseif ($data['value'] === 'unsubmitted') {
                                $query->whereDoesntHave('publicForm', function (Builder $query) {
                                });
                            }
                        }
                    )
                )

            ],layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                    Tables\Actions\Action::make('pdf')
                    ->iconButton()
                    ->tooltip('Download pdf')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (Code $record) => route('pdf', $record))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->publicForm && $record->publicForm->submitted_at),
                    Tables\Actions\Action::make('openForm')
                    ->iconButton()
                    ->tooltip('Open Form')
                    ->icon('heroicon-s-square-2-stack')
                    ->color('primary')
                    ->url(fn ($record) => route('public-form', Crypt::encryptString($record->id)))
                    ->openUrlInNewTab(),

            ])
            ->bulkActions([
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
            'index' => Pages\ListCodes::route('/'),
            'create' => Pages\CreateCode::route('/create'),
            'edit' => Pages\EditCode::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()->with('user_code');
    // }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ViewEntry::make('Code')->view('infolists.components.cude-u-r-l')
                // ->suffixAction(
                //     Action::make('copyCostToPrice')
                //         ->icon('heroicon-m-clipboard')
                //         ->requiresConfirmation()
                //         ->action(function (Product $record) {
                //             $record->code = $record->cost;
                //             $record->save();
                //         })
                // )
            ]);
    }

    protected function getTableQuery(): Builder
    {
        // Pastikan untuk memuat relasi 'publicForm'
        return Code::query()->with('publicForm');
    }
    
}
