<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Tables\View\TablesRenderHook;



class SummaryDashboard extends Widget
{
    protected static string $view = 'filament.widgets.summary-dashboard';
    protected int | string | array $columnSpan = 'full';
    use InteractsWithPageFilters;

    public function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        
        $data = DB::table('users as u')
            ->leftJoin('codes as c', 'c.created_by', '=', 'u.id')
            ->leftJoin('public_forms as p', function($join) use ($startDate,$endDate){
                $join->on('p.code_id', '=', 'c.id');
                $join->when($startDate, fn ($query) => $query->on('submitted_at', '>=',DB::raw("'{$startDate}'")));
                $join->when($endDate, fn ($query) => $query->on('submitted_at', '<=',DB::raw("'{$endDate}'")));
            })
            ->selectRaw('
                u.name as user_name,
                IFNULL(COUNT(p.code_id),0) as total_codes,
                IFNULL(AVG(kepuasan_1),0) AS kepuasan_1,
                IFNULL(AVG(kepuasan_2),0) AS kepuasan_2,
                IFNULL(AVG(kepuasan_3),0) AS kepuasan_3,
                IFNULL(AVG(kepuasan_4),0) AS kepuasan_4,
                IFNULL(AVG(kepuasan_5),0) AS kepuasan_5,
                IFNULL(AVG(kepuasan_6),0) AS kepuasan_6,
                IFNULL(AVG(kepuasan_7),0) AS kepuasan_7,
                IFNULL(AVG(kepuasan_8),0) AS kepuasan_8,
                IFNULL(AVG(kepuasan_9),0) AS kepuasan_9,
                IFNULL(AVG(kepentingan_1),0) AS kepentingan_1,
                IFNULL(AVG(kepentingan_2),0) AS kepentingan_2,
                IFNULL(AVG(kepentingan_3),0) AS kepentingan_3,
                IFNULL(AVG(kepentingan_4),0) AS kepentingan_4,
                IFNULL(AVG(kepentingan_5),0) AS kepentingan_5,
                IFNULL(AVG(kepentingan_6),0) AS kepentingan_6,
                IFNULL(AVG(kepentingan_7),0) AS kepentingan_7,
                IFNULL(AVG(kepentingan_8),0) AS kepentingan_8,
                IFNULL(AVG(kepentingan_9),0) AS kepentingan_9,
                IFNULL(AVG(korupsi_1),0) AS korupsi_1,
                IFNULL(AVG(korupsi_2),0) AS korupsi_2,
                IFNULL(AVG(korupsi_3),0) AS korupsi_3,
                IFNULL(AVG(korupsi_4),0) AS korupsi_4,
                IFNULL(AVG(korupsi_5),0) AS korupsi_5,
                IFNULL(AVG(korupsi_6),0) AS korupsi_6,
                IFNULL(AVG(korupsi_7),0) AS korupsi_7,
                IFNULL(AVG(korupsi_8),0) AS korupsi_8,
                IFNULL(AVG(korupsi_9),0) AS korupsi_9
            ')
            ->groupBy('u.name')
            ->get();

            $row=$data->map(function ($user) {
                return [
                    'user_name' => $user->user_name,
                    'total_codes' => $user->total_codes,
                    'avg_kepuasan' => collect($user->kepuasan_1,$user->kepuasan_2,$user->kepuasan_3,$user->kepuasan_4,$user->kepuasan_5,$user->kepuasan_6,$user->kepuasan_7,$user->kepuasan_8,$user->kepuasan_9)->avg(),
                    'avg_kepentingan' => collect($user->kepentingan_1,$user->kepentingan_2,$user->kepentingan_3,$user->kepentingan_4,$user->kepentingan_5,$user->kepentingan_6,$user->kepentingan_7,$user->kepentingan_8,$user->kepentingan_9)->avg(),
                    'avg_korupsi' => collect($user->korupsi_1,$user->korupsi_2,$user->korupsi_3,$user->korupsi_4,$user->korupsi_5,$user->korupsi_6,$user->korupsi_7,$user->korupsi_8,$user->korupsi_9)->avg()
                ];
            });

            $total_avg_kepuasan = $data->map(function ($publicForm) {
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

            $total_avg_kepentingan = $data->map(function ($publicForm) {
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

            $total_avg_korupsi = $data->map(function ($publicForm) {
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
       
        
        $return = [
            'data'=>$row->toArray(),
            'total_kepuasan'=>$total_avg_kepuasan->avg(),
            'total_kepentingan'=>$total_avg_kepentingan->avg(),
            'total_korupsi'=>$total_avg_korupsi->avg()
        ];

        return $return;
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
