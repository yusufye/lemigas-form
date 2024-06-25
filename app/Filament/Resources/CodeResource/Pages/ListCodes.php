<?php

namespace App\Filament\Resources\CodeResource\Pages;

use App\Models\Code;
use Filament\Actions;
use App\Filament\Resources\CodeResource;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListCodes extends ListRecords
{
    protected static string $resource = CodeResource::class;

    public static function title()
    {
        return 'Judul Baru - ' . Auth::user()->name;
    }
    
    protected function getHeaderActions(): array
    {
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
            1=>'Tidak Penting',
            2=>'Kurang Penting',
            3=>'Penting',
            4=>'Sangat Penting'
        ];
            
        $radio_label=[
            1=>'Tidak Puas',
            2=>'Kurang Puas',
            3=>'Puas',
            4=>'Sangat Puas'
        ];
        
        $data_default=array(
            Column::make('code')->heading('Code'),
            Column::make('user')->heading('User'),
            Column::make('publicForm.company_name')->heading('Nama Perusahaan'),
            Column::make('publicForm.company_address')->heading('Alamat Perusahaan'),
            Column::make('publicForm.company_phone')->heading('Telepon/Fax'),
        );

        $data_kepentingan=$data_default;
        for ($i=1; $i < 9; $i++) { 
            $data_kepentingan[]=Column::make('publicForm.kepentingan_'.$i)->heading($input_label[$i]);
        }
        $data_kepentingan[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_kepentingan[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');

        $data_kepuasan=$data_default;
        for ($i=1; $i < 9; $i++) { 
            $data_kepuasan[]=Column::make('publicForm.kepuasan_'.$i)->heading($input_label[$i]);
        }
        $data_kepuasan[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_kepuasan[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');

        $data_korupsi=$data_default;
        for ($i=1; $i < 9; $i++) { 
            $data_korupsi[]=Column::make('publicForm.korupsi_'.$i)->heading($input_label[$i]);
        }
        $data_korupsi[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_korupsi[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');

        
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
            ->exports([
                ExcelExport::make('Kepentingan')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        ->whereHas('publicForm', function ($query) {
                            $query->whereNotNull('submitted_at');
                        })
                    )
                    ->withFilename(fn ($resource) =>  'form_kepentingan_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_kepentingan),
                ExcelExport::make('Kepuasan')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        ->whereHas('publicForm', function ($query) {
                            $query->whereNotNull('submitted_at');
                        })
                    )
                    ->withFilename(fn ($resource) =>  'form_kepuasan_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_kepuasan),
                ExcelExport::make('Korupsi')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        ->whereHas('publicForm', function ($query) {
                            $query->whereNotNull('submitted_at');
                        })
                    )
                    ->withFilename(fn ($resource) =>  'form_korupsi_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_korupsi),

                
            ])->label('Export')
        ];
    }
}
