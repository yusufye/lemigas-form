<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class KepuasanOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    protected int | string | array $columnSpan = '1';

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $user_id = $this->filters['user_id'] ?? null;


        $publicForms = PublicForm::with('code')
        ->whereHas('code', function($query) use ($user_id) {
            $query->where('is_active', 1)
            ->when($user_id, fn (Builder $query) => $query->whereIn('created_by', $user_id))
            ->when(!auth()->user()->hasRole('super_admin'), fn (Builder $query) => $query->where('created_by', auth()->id()));
        })
        ->whereNotNull('submitted_at')
        ->when($startDate, fn (Builder $query) => $query->whereDate('submitted_at', '>=', $startDate))
        ->when($endDate, fn (Builder $query) => $query->whereDate('submitted_at', '<=', $endDate))
        ->get([
            'kepuasan_1', 'kepuasan_2', 'kepuasan_3', 
            'kepuasan_4', 'kepuasan_5', 'kepuasan_6', 
            'kepuasan_7', 'kepuasan_8', 'kepuasan_9'
        ]);

        $rowAverages = $publicForms->map(function ($publicForm) {
            $values = collect([
                $publicForm->kepuasan_1,
                $publicForm->kepuasan_2,
                $publicForm->kepuasan_3,
                $publicForm->kepuasan_4,
                $publicForm->kepuasan_5,
                $publicForm->kepuasan_6,
                $publicForm->kepuasan_7,
                $publicForm->kepuasan_8,
                $publicForm->kepuasan_9,
            ])->filter(); // Menghapus nilai null
            return $values->avg();
        });
        return [
            Stat::make('Nilai Kepuasan', round($rowAverages->avg(), 2))
        ];
    }
}
