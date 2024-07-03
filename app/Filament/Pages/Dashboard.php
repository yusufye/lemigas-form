<?php
 
namespace App\Filament\Pages;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
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
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                    ])
                    ->columns(3),
            ]);
    }

}