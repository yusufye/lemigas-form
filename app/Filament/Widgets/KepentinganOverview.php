<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class KepentinganOverview extends BaseWidget
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
            'kepentingan_1', 'kepentingan_2', 'kepentingan_3', 
            'kepentingan_4', 'kepentingan_5', 'kepentingan_6', 
            'kepentingan_7', 'kepentingan_8', 'kepentingan_9'
        ]);
        

        $rowAverages = $publicForms->map(function ($publicForm) {
            $values = collect([
                $publicForm->kepentingan_1,
                $publicForm->kepentingan_2,
                $publicForm->kepentingan_3,
                $publicForm->kepentingan_4,
                $publicForm->kepentingan_5,
                $publicForm->kepentingan_6,
                $publicForm->kepentingan_7,
                $publicForm->kepentingan_8,
                $publicForm->kepentingan_9,
            ])->filter(); // Menghapus nilai null
        
            return $values->avg();
        });

        return [
            Stat::make('Rata-rata Kepentingan', round($rowAverages->avg(), 2))
        ];
    }
}
