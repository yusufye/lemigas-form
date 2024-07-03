<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;

use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;


class KepentinganChart extends ChartWidget
{
    protected static ?string $heading = 'Rata-Rata Kepentingan';
    use InteractsWithPageFilters;

    protected function getData(): array
{
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

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

        $radio_label_kepentingan=[
            1 => 'Tidak Penting',
            2 => 'Kurang Penting',
            3 => 'Penting',
            4 => 'Sangat Penting'
        ];

        // Ambil data dengan join dan kondisi yang diperlukan
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

        // Menghitung rata-rata untuk setiap kolom
        $averages = [
        'kepentingan_1' => $publicForms->avg('kepentingan_1'),
        'kepentingan_2' => $publicForms->avg('kepentingan_2'),
        'kepentingan_3' => $publicForms->avg('kepentingan_3'),
        'kepentingan_4' => $publicForms->avg('kepentingan_4'),
        'kepentingan_5' => $publicForms->avg('kepentingan_5'),
        'kepentingan_6' => $publicForms->avg('kepentingan_6'),
        'kepentingan_7' => $publicForms->avg('kepentingan_7'),
        'kepentingan_8' => $publicForms->avg('kepentingan_8'),
        'kepentingan_9' => $publicForms->avg('kepentingan_9'),
        ];

        // Format data untuk Chart.js
        $averages = [
            'kepentingan_1' => $publicForms->avg('kepentingan_1'),
            'kepentingan_2' => $publicForms->avg('kepentingan_2'),
            'kepentingan_3' => $publicForms->avg('kepentingan_3'),
            'kepentingan_4' => $publicForms->avg('kepentingan_4'),
            'kepentingan_5' => $publicForms->avg('kepentingan_5'),
            'kepentingan_6' => $publicForms->avg('kepentingan_6'),
            'kepentingan_7' => $publicForms->avg('kepentingan_7'),
            'kepentingan_8' => $publicForms->avg('kepentingan_8'),
            'kepentingan_9' => $publicForms->avg('kepentingan_9'),
        ];
        
      
        return [
            'datasets' => [
                [
                    'label' => $startDate,
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
                options: {
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        position: 'nearest',
                        callbacks: {
                            // Custom tooltip position callback
                            position: function(tooltipModel) {
                                // Default position is 'average', you can customize it
                                tooltipModel.yAlign = 'top';
                                return tooltipModel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
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
