<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'key'   => 'target_skm',
                'type'  => 'number',
                'value' => '3',
                'desc'  => 'Ambang batas penilaian'
            ],
            [
                'key'   => 'code_max_file_upload',
                'type'  => 'number',
                'value' => '5',
                'desc'  => 'Maksimal jumlah file yang di upload pada Code'
            ],
            [
                'key'   => 'code_max_size_upload',
                'type'  => 'number',
                'value' => '10240',
                'desc'  => 'Maksimal ukuran file yang di upload pada code dalam MB'
            ],
        ]);
    }
}
