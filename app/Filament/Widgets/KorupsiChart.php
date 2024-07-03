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

    protected static ?string $heading = 'Rata-Rata Korupsi';

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

        $radio_label_korupsi=[
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
            'korupsi_1', 'korupsi_2', 'korupsi_3', 
            'korupsi_4', 'korupsi_5', 'korupsi_6', 
            'korupsi_7', 'korupsi_8', 'korupsi_9'
        ]);

        // Menghitung rata-rata untuk setiap kolom
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
                    'label' => 'Chart korupsi',
                    'data' => array_values($averages),
                ],
            ],
            'labels' => array_keys($input_label)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

}
