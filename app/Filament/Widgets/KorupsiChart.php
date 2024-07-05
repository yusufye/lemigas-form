<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;

use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class KorupsiChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Korupsi';

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $user_id = $this->filters['user_id'] ?? null;


        $input_label = [
            1 => 'Persyaratan (administrasi dan dokumen)',
            2 => 'Prosedur (mekanisme registrasi dan pembayaran)',
            3 => 'Waktu penyelesaian layanan',
            4 => 'Biaya/tarif (kewajaran biaya)',
            5 => 'Produk spesifikasi jenis layanan',
            6 => 'Kompetensi pelaksanan layanan',
            7 => 'Perilaku Pelaksana (keramahan dan komunikatif)',
            8 => 'Penanganan aduan, saran dan masukan',
            9 => 'Fasilitas (kenyamanan, kemudahan informasi dan keamanan lingkungan)',
        ];

        // Ambil data dengan join dan kondisi yang diperlukan
        $publicForms = PublicForm::with('code')
        ->whereHas('code', function($query) use ($user_id) {
            $query->where('is_active', 1)
            ->when($user_id, fn (Builder $query) => $query->whereIn('created_by', $user_id))
            ->when(!auth()->user()->hasRole('super_admin'), fn (Builder $query) => $query->where('created_by', auth()->id()));
        })
        ->whereNotNull('submitted_at')
        ->when($startDate, fn (Builder $query) => $query->whereDate('submitted_at', '>=', $startDate))
        ->when($endDate, fn (Builder $query) => $query->whereDate('submitted_at', '<=', $endDate))
        // ->toSql();dd($publicForms);
       ->get([ 'korupsi_1', 'korupsi_2', 'korupsi_3', 'korupsi_4', 'korupsi_5', 'korupsi_6', 'korupsi_7', 'korupsi_8', 'korupsi_9' ]);

        // Format data untuk Chart.js
        $averages = [
            'korupsi_1' => $publicForms->avg('korupsi_1'),
            'korupsi_2' => $publicForms->avg('korupsi_2'),
            'korupsi_3' => $publicForms->avg('korupsi_3'),
            'korupsi_4' => $publicForms->avg('korupsi_4'),
            'korupsi_5' => $publicForms->avg('korupsi_5'),
            'korupsi_6' => $publicForms->avg('korupsi_6'),
            'korupsi_7' => $publicForms->avg('korupsi_7'),
            'korupsi_8' => $publicForms->avg('korupsi_8'),
            'korupsi_9' => $publicForms->avg('korupsi_9'),
        ];
        
      
        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata',
                    'data' => array_values($averages),
                ],
            ],
            'labels' => array_keys($input_label)
        ];
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: function(value){
                                let x_tooltip=[
                                    'Persyaratan (administrasi dan dokumen)',
                                    'Prosedur (mekanisme registrasi dan pembayaran)',
                                    'Waktu penyelesaian layanan',
                                    'Biaya/tarif (kewajaran biaya)',
                                    'Produk spesifikasi jenis layanan',
                                    'Kompetensi pelaksanan layanan',
                                    'Perilaku Pelaksana (keramahan dan komunikatif)',
                                    'Penanganan aduan, saran dan masukan',
                                    'Fasilitas (kenyamanan, kemudahan informasi dan keamanan lingkungan)',
                                ]
                                let x=parseInt(value[0].label)-1;
                                return x_tooltip[x];
                            }
                        }
                    },
                    legend:{
                        display:false
                    }
                }
            }
        JS);
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
