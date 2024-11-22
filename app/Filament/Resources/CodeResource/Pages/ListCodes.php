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

        $input_label_korupsi = [
            1 => 'Prosedur pelayanan yang ditetapkan sudah memadai dan tidak berpotensi menimbulkan KKN',
            2 => 'Petugas pelayanan tdak memberikan pelayanan di luar prosedur yang telah ditetapkan',
            3 => 'Tidak terdapat praktek pen-calo-an/perantara yang tidak resmi',
            4 => 'Petugas pelayanan tidak diskriminasi',
            5 => 'Tidak terdapat pungutan liar dalam pelayanan',
            6 => 'Petugas pelayanan tidak meminta/menuntut imbalan uang/barang terkait pelayanan yang diberikan',
            7 => 'Petugas pelayanan tidak memberi kode atau isyarat terkait kimbalan uang / barang dan menolak pemberian uang / barang terkait pelayanan yang diberikan',
            8 => 'Jasa pelayanan yang diterima sesuai dengan daftar jasa layanan yang tersedia / diminta',
            9 => 'Tidak diskriminatif dalam penanganan pengaduan',
        ];

        $enum_jenis_pelayanan=['UJI_LAB'=>'Uji Lab','TENAGA_AHLI'=>'Tenaga Ahli','JASA_STUDI'=>'Jasa Studi','PENYEWAAN_ALAT'=>'Penyewaan Alat','JASA_BLENDING'=>'Jasa Blending','JASA_SERTIFIKASI_PRODUK'=>'Jasa Sertifikasi Produk'];
        $enum_jenis_kemalin=['MALE'=>'Pria','FEMALE'=>'Wanita'];
    
        
        $data_default=array(
            Column::make('code')->heading('Code'),
            Column::make('user')->heading('User'),
            Column::make('publicForm.company_name')->heading('Nama Perusahaan'),
            Column::make('publicForm.company_address')->heading('Alamat Perusahaan'),
            Column::make('publicForm.company_phone')->heading('Telepon/Fax'),
        );

        $data_default_korupsi=array(
            Column::make('publicForm.jenis_pelayanan')->heading('Jenis Pelayanan')->formatStateUsing(fn ($state) => $enum_jenis_pelayanan[$state] ),
            Column::make('publicForm.responden_age')->heading('Usia Responden'),
            Column::make('publicForm.responden_gender')->heading('Jenis Kelamin')->formatStateUsing(fn ($state) => $enum_jenis_kemalin[$state] ),
            Column::make('publicForm.responden_education')->heading('Pendidikan Responden')
        );

        

        $data_kepentingan=$data_default;
        for ($i=1; $i <= 9; $i++) { 
            $data_kepentingan[]=Column::make('publicForm.kepentingan_'.$i)->heading($input_label[$i]);
        }
        $data_kepentingan[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_kepentingan[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');

        $data_kepuasan=$data_default;
        for ($i=1; $i <= 9; $i++) { 
            $data_kepuasan[]=Column::make('publicForm.kepuasan_'.$i)->heading($input_label[$i]);
        }
        $data_kepuasan[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_kepuasan[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');

        $data_korupsi=array_merge($data_default,$data_default_korupsi);
        for ($i=1; $i <= 9; $i++) { 
            $data_korupsi[]=Column::make('publicForm.korupsi_'.$i)->heading($input_label_korupsi[$i]);
        }
        // $data_korupsi[]=Column::make('publicForm.remark')->heading('Catatan dan komentar');
        $data_korupsi[]=Column::make('publicForm.complaint')->heading('Catatan dan Pengaduan');
        $data_korupsi[]=Column::make('publicForm.submitted_at')->heading('Tanggal form disimpan');
        

        
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
            ->exports([
                ExcelExport::make('Kepentingan')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        // ->whereHas('publicForm', function ($query) {
                        //     $query->whereNotNull('submitted_at');
                        // })
                    )
                    ->withFilename(fn ($resource) =>  'form_kepentingan_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_kepentingan),
                ExcelExport::make('Kepuasan')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        // ->whereHas('publicForm', function ($query) {
                        //     $query->whereNotNull('submitted_at');
                        // })
                    )
                    ->withFilename(fn ($resource) =>  'form_kepuasan_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_kepuasan),
                ExcelExport::make('Korupsi')
                    ->fromTable()
                    ->except([ 'is_active', 'user'])
                    ->modifyQueryUsing(fn ($query) => $query->where('is_active', true)
                        // ->whereHas('publicForm', function ($query) {
                        //     $query->whereNotNull('submitted_at');
                        // })
                    )
                    ->withFilename(fn ($resource) =>  'form_korupsi_' . date('dMY_His'))
                    // ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns($data_korupsi),

                
            ])->label('Export')
        ];
    }
}
