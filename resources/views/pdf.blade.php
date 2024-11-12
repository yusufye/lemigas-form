<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Survei Kualitas Pelayanan BBPMGB LEMIGAS</title>
    <style>

        body{
            font-family: Arial, sans-serif; /* Mengatur font menjadi Arial */
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }
        .header {
            margin-bottom: 5px;
        }

        .footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .footer p {
            margin-top:5px;
        }

        .div-outline {
            width:100%;
            outline:1px solid black;
        }
    </style>
</head>
<body>
    @php
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
        
        $radio_kepuasan=[ 1=>'Tidak Puas', 2=>'Kurang Puas', 3=>'Puas', 4=>'Sangat Puas' ];

        $radio_kepentingan=[ 1=>'Tidak Penting', 2=>'Kurang Penting', 3=>'Penting', 4=>'Sangat Penting' ];

        $radio_korupsi=[ 1=>'Tidak Sesuai', 2=>'Kurang Sesuai', 3=>'Sesuai', 4=>'Sangat Sesuai' ];

        $enum_pelayanan=['UJI_LAB'=>'Uji Lab','TENAGA_AHLI'=>'Tenaga Ahli','JASA_STUDI'=>'Jasa Studi','PENYEWAAN_ALAT'=>'Penyewaan Alat','JASA_BLENDING'=>'Jasa Blending','JASA_SERTIFIKASI_PRODUK'=>'Jasa Sertifikasi Produk',];

        
    @endphp 

    <div class="header">
        <table>
            <tr>
                <td rowspan="3" style="font-family:'Courier New';color:blue"><h1>LEMIGAS</h1></td>
                <td><h3>BALAI BESAR PENGUJIAN MINYAK DAN GAS BUMI LEMIGAS</h3></td>
                <td class="left" style="border-right-style: hidden; border-bottom-style: hidden;">Nomor Formulir</td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">:</td>
                <td class="left" style="border-bottom-style: hidden;">F.8.P.01-A</td>
            </tr>
            <tr>
                
                <td rowspan="2"><h3>KUESIONER SURVEI KUALITAS PELAYANAN BBPMGB LEMIGAS</h3></td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">Revisi</td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">:</td>
                <td class="left" style="border-bottom-style: hidden;">L.1</td>
            </tr>
            <tr>
                <td class="left" style="border-right-style: hidden;">Halaman </td>
                <td class="left" style="border-right-style: hidden;">:</td>
                <td class="left" style="">1 Dari 1</td>
            </tr>
        </table>

        <div class="div-outline left">
            <p style="padding: 5px;">Nama Perussahaan : {{$record->publicForm->company_name}}</p>
            <p style="padding: 5px;">Alamat Perussahaan : {{$record->publicForm->company_address}}</p>
            <p style="padding: 5px;">Telepon / Fax : {{$record->publicForm->company_phone}}</p>
        </div>
    </div>

    <h3>A. Kepentingan Layanan</h3>
    <p>Seberapa penting menurut Anda mendapatkan aspek layanan tersebut (Importance)?</p>
    <table class="left">
        <thead>
            <tr>
                <th>No.</th>
                <th>Deskripsi</th>
                @foreach($radio_kepentingan as $key => $label)
                    <th>{{ $key }}<br/>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($input_label as $key => $label)
                <tr>
                    <td>{{ $key }}</td>
                    <td class="left">{{ $label }}</td>
                    @foreach($radio_kepentingan as $radio_key => $radio )
                    @php
                    $fieldName_kepentingan = "kepentingan_{$key}";
                    @endphp
                    
                        @if ($record->publicForm->$fieldName_kepentingan==$radio_key)
                        <td> V </td>
                         @else
                         <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="padding-bottom: 10px;">Ket: Beri Tanda V pada pilihan</p>


    <h3>B.Kepuasan Layanan</h3>
    <p>Seberapa puas Anda mendapatkan aspek layanan tersebut (Performance)?</p>
    <table align="left">
        <thead>
            <tr>
                <th>No.</th>
                <th>Deskripsi</th>
                @foreach($radio_kepuasan as $key => $label)
                    <th>{{ $key }}<br/>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($input_label as $key => $label)
                <tr>
                    <td>{{ $key }}</td>
                    <td class="left">{{ $label }}</td>
                    @foreach($radio_kepuasan as $radio_key => $radio )
                    @php
                    $fieldName_kepuasan = "kepuasan_{$key}";
                    @endphp
                    
                        @if ($record->publicForm->$fieldName_kepuasan==$radio_key)
                        <td> V </td>
                         @else
                         <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Ket: Beri Tanda V pada pilihan</p>
    <p>Saran dan Komentar:{{$record->publicForm->remark}}</p>
    <p class="right" style="padding-right:120px;">Jakarta, {{date('d M Y',strtotime($record->publicForm->submitted_at))}}</p>
    <p class="right" style="padding-right:150px;padding-bottom: 10px;">Pelanggan</p>
    <p class="right" style="padding-right:120px;"><img src="{{public_path('storage/'.$record->publicForm->signature_path)}}" alt="" style="max-width: 100px;"></p>
    <p class="right" style="padding-right:100px;">(___________________________)</p>

    <div class="footer">
        <p class="left">Distribusi: 1.arsip 2. Unit Adm.</p>
        <p class="center"><small> Dokumen ini milik Balai Besar Pengujian Minyak dan Gas Bumi LEMIGAS, isi dari dokumen ini tidak diperkenankan untuk digandakan atau disalin baik seluruh atau sebagian tanpa izin tertulis dari Balai Besar Pengujian Minyak dan Gas Bumi LEMIGAS</small></p>
    </div>

    {{-- Page Break --}}
    <div style="page-break-after: always;"></div>

    {{-- Korpsi --}}
    <div class="header">
        <table>
            <tr>
                <td rowspan="3" style="font-family:'Courier New';color:blue"><h1>LEMIGAS</h1></td>
                <td><h3>BALAI BESAR PENGUJIAN MINYAK DAN GAS BUMI LEMIGAS</h3></td>
                <td class="left" style="border-right-style: hidden; border-bottom-style: hidden;">Nomor Formulir</td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">:</td>
                <td class="left" style="border-bottom-style: hidden;">F.8.P.01-B</td>
            </tr>
            <tr>
                
                <td rowspan="2"><h3>KUESIONER SURVEI KUALITAS PELAYANAN BBPMGB LEMIGAS</h3></td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">Revisi</td>
                <td class="left" style="border-right-style: hidden;border-bottom-style: hidden;">:</td>
                <td class="left" style="border-bottom-style: hidden;">L.1</td>
            </tr>
            <tr>
                <td class="left" style="border-right-style: hidden;">Halaman </td>
                <td class="left" style="border-right-style: hidden;">:</td>
                <td class="left" style="">1 Dari 1</td>
            </tr>
        </table>

        
    </div>

    <div class="left" style="padding-bottom: 10px;">
        <h3>DATA UNIT PELAYANAN</h3>
        <p style="padding: 5px;">Nama Unit Pelayanan : BALAI BESAR PENGUJIAN MINYAK DAN GAS BUMI LEMIGAS</p>
        <p style="padding: 5px;">Spesifikasi Jenis Pelayanan : {{(!empty($record->publicForm->jenis_pelayanan))?$enum_pelayanan[$record->publicForm->jenis_pelayanan]:'-'}}</p>
    </div>

    <div class="left" style="padding-bottom: 10px;">
        <h3>DATA RESPONDEN</h3>
        <p style="padding: 5px;">Nama Perusahaan : {{$record->publicForm->company_name}}</p>
        <p style="padding: 5px;">Usia/Umur Responden : {{$record->publicForm->responden_age}} Tahun</p>
        <p style="padding: 5px;">Jenis Kelamin : {{($record->publicForm->responden_gender=='MALE'?'Pria':'Wanita')}}</p>
        <p style="padding: 5px;">Pendidikan : {{$record->publicForm->responden_education}}</p>
    </div>

    <h3>DATA KUISIONER</h3>
    <p>Beri Tanda (V) pada jawaban yang sesuai</p>
    <table class="left">
        <thead>
            <tr>
                <th>No.</th>
                <th>Pertanyaan</th>
                @foreach($radio_korupsi as $key => $label)
                    <th>{{ $key }}<br/>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($input_label_korupsi as $key => $label)
                <tr>
                    <td>{{ $key }}</td>
                    <td class="left">{{ $label }}</td>
                    @foreach($radio_korupsi as $radio_key => $radio )
                    @php
                    $fieldName_korupsi = "korupsi_{$key}";
                    @endphp
                    
                        @if ($record->publicForm->$fieldName_korupsi==$radio_key)
                        <td> V </td>
                         @else
                         <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Saran dan Pengaduan:{{$record->publicForm->complaint}}</p>
    <p>Nama Petugas:{{$record->user_created->name}}</p>
    <p>Tanggal Survei:{{date('d M Y',strtotime($record->publicForm->submitted_at))}}</p>
    <p class="right" style="padding-right:120px;">Jakarta, {{date('d M Y',strtotime($record->publicForm->submitted_at))}}</p>
    <p class="right" style="padding-right:150px;padding-bottom: 10px;">Pelanggan,</p>
    <p class="right" style="padding-right:120px;"><img src="{{public_path('storage/'.$record->publicForm->signature_path)}}" alt="" style="max-width: 100px;"></p>
    <p class="right" style="padding-right:100px;">(___________________________)</p>

    <div class="footer">
        <p class="left">Distribusi: 1.arsip 2. Unit Adm.</p>
        <p class="center"><small> Dokumen ini milik Balai Besar Pengujian Minyak dan Gas Bumi LEMIGAS, isi dari dokumen ini tidak diperkenankan untuk digandakan atau disalin baik seluruh atau sebagian tanpa izin tertulis dari Balai Besar Pengujian Minyak dan Gas Bumi LEMIGAS</small></p>
    </div>

    </body>
</html>
