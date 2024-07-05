<?php
 
namespace App\Filament\Pages;
use App\Models\Code;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
 
class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;
 
    public function getColumns(): int | string | array
    {
        return 2;
    }

    public function filtersForm(Form $form): Form
    {
        $users =  User::when(!auth()->user()->hasRole('super_admin'), function ($query) {
            $query->where('id', auth()->id());
        })
        ->pluck('name', 'id')
        ->toArray();

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                        Select::make('user_id')
                        ->options($users)
                        ->label('Select User')
                        ->searchable()
                        ->multiple()
                        ->visible(auth()->user()->hasRole('super_admin')),
                    ])
                    ->columns(3),
            ]);
    }

}