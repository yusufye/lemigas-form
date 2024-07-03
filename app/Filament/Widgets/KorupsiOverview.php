<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class KorupsiOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected int | string | array $columnSpan = '1';
    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $publicForms = PublicForm::with('code')
        ->whereHas('code', function($query) {
            $query->where('is_active', 1);
        })
        ->whereNotNull('submitted_at')
        ->when($startDate, fn (Builder $query) => $query->whereDate('submitted_at', '>=', $startDate))
        ->when($endDate, fn (Builder $query) => $query->whereDate('submitted_at', '<=', $endDate))
        ->get([
            'korupsi_1', 'korupsi_2', 'korupsi_3', 
            'korupsi_4', 'korupsi_5', 'korupsi_6', 
            'korupsi_7', 'korupsi_8', 'korupsi_9'
        ]);
        

        $rowAverages = $publicForms->map(function ($publicForm) {
            $values = collect([
                $publicForm->korupsi_1,
                $publicForm->korupsi_2,
                $publicForm->korupsi_3,
                $publicForm->korupsi_4,
                $publicForm->korupsi_5,
                $publicForm->korupsi_6,
                $publicForm->korupsi_7,
                $publicForm->korupsi_8,
                $publicForm->korupsi_9,
            ])->filter(); // Menghapus nilai null
        
            return $values->avg();
        });
        
        return [
            Stat::make('Rata-rata korupsi', round($rowAverages->avg(), 2))
        ];
    }
}
