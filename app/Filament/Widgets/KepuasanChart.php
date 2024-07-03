<?php

namespace App\Filament\Widgets;

use App\Models\PublicForm;
use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;

use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
class KepuasanChart extends ChartWidget
{
    protected static ?string $heading = 'Rata-Rata Kepuasan';
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

        $radio_label_kepuasan=[
            1 => 'Tidak Puas',
            2 => 'Kurang Puas',
            3 => 'Puas',
            4 => 'Sangat Puas'
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
            'kepuasan_1', 'kepuasan_2', 'kepuasan_3', 
            'kepuasan_4', 'kepuasan_5', 'kepuasan_6', 
            'kepuasan_7', 'kepuasan_8', 'kepuasan_9'
        ]);

        // Menghitung rata-rata untuk setiap kolom
        $averages = [
        'kepuasan_1' => $publicForms->avg('kepuasan_1'),
        'kepuasan_2' => $publicForms->avg('kepuasan_2'),
        'kepuasan_3' => $publicForms->avg('kepuasan_3'),
        'kepuasan_4' => $publicForms->avg('kepuasan_4'),
        'kepuasan_5' => $publicForms->avg('kepuasan_5'),
        'kepuasan_6' => $publicForms->avg('kepuasan_6'),
        'kepuasan_7' => $publicForms->avg('kepuasan_7'),
        'kepuasan_8' => $publicForms->avg('kepuasan_8'),
        'kepuasan_9' => $publicForms->avg('kepuasan_9'),
        ];

        // Format data untuk Chart.js
        $averages = [
            'kepuasan_1' => $publicForms->avg('kepuasan_1'),
            'kepuasan_2' => $publicForms->avg('kepuasan_2'),
            'kepuasan_3' => $publicForms->avg('kepuasan_3'),
            'kepuasan_4' => $publicForms->avg('kepuasan_4'),
            'kepuasan_5' => $publicForms->avg('kepuasan_5'),
            'kepuasan_6' => $publicForms->avg('kepuasan_6'),
            'kepuasan_7' => $publicForms->avg('kepuasan_7'),
            'kepuasan_8' => $publicForms->avg('kepuasan_8'),
            'kepuasan_9' => $publicForms->avg('kepuasan_9'),
        ];
        
        
        // Format data untuk Chart.js
        $chartData = [
            'datasets' => [
                [
                    'label' => 'Chart kepuasan',
                    'data' => array_values($averages),
                ],
            ],
            'labels' => array_keys($input_label)
        ];
        
        // Mengembalikan data dalam format yang dibutuhkan oleh Chart.js
        return $chartData;
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // protected function getOptions(): RawJs
    // {
    //     $radio_label_kepuasan=[
    //         1 => 'Tidak Penting',
    //         2 => 'Kurang Penting',
    //         3 => 'Penting',
    //         4 => 'Sangat Penting'
    //     ];

    //     return RawJs::make(<<<JS
    //     {
    //         scales: {
    //             y: {
    //                 // type: 'linear',
    //                 ticks: {
    //                     callback: function(value, index, values) {
    //                             const labels = ['Tidak Puas', 'Kurang Puas', 'Puas', 'Sangat Puas'];
    //                             const roundedValue = Math.round(value); // Membulatkan nilai ke integer terdekat
    //                             return labels[roundedValue - 1] || '';
    //                         }
    //                 },
    //             },
    //         },
    //     }
    //     JS);
    // }
}
