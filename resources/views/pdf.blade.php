<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Form PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
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
        
        $radio_label=[
            1=>'Tidak Puas',
            2=>'Kurang Puas',
            3=>'Puas',
            4=>'Sangat Puas'
];
    @endphp 
    
    <div class="header">
        <h1>Public Form</h1>
        <p>Code: {{ $record->code }}</p>
        <p>Submitted At: {{ $record->publicForm->submitted_at }}</p>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li><strong>Nama Perusahaan:</strong> {{ $record->publicForm->company_name }}</li>
                    <li><strong>Alamat Perusahaan:</strong> {{ $record->publicForm->company_address }}</li>
                    <li><strong>Telepon/Fax:</strong> {{ $record->publicForm->company_phone }}</li>
                    <!-- Tambahkan item lain sesuai kebutuhan -->
                </ul>
            </div>
            <div class="mb-3">
    <h3>Kepentingan</h3>
    <ul>
        @for($i = 1; $i <= 9; $i++)
            @php
                $label_kepentingan = $input_label[$i];
                
                $fieldName = "kepentingan_{$i}";
                $kepentinganValue = isset($record->publicForm->$fieldName) ? $record->publicForm->$fieldName : null;
                $label_radio_kepentingan = $radio_label[$kepentinganValue];
            @endphp
            <li>
                {{ $label_kepentingan }}: {{ $label_radio_kepentingan }}
            </li>
        @endfor
    </ul>

    <h3>Kepuasan</h3>
    <ul>
        @for($i = 1; $i <= 9; $i++)
            @php
                $label_kepuasan = $input_label[$i];
                
                $fieldName = "kepuasan_{$i}";
                $kepuasanValue = isset($record->publicForm->$fieldName) ? $record->publicForm->$fieldName : null;
                $label_radio_kepuasan = $radio_label[$kepuasanValue];
            @endphp
            <li>
                {{ $label_kepuasan }}: {{ $label_radio_kepuasan }}
            </li>
        @endfor
    </ul>

    <h3>Korupsi</h3>
    <ul>
        @for($i = 1; $i <= 9; $i++)
            @php
                $label_korupsi = $input_label[$i];
                
                $fieldName = "korupsi_{$i}";
                $korupsiValue = isset($record->publicForm->$fieldName) ? $record->publicForm->$fieldName : null;
                $label_radio_korupsi = $radio_label[$korupsiValue];
            @endphp
            <li>
                {{ $label_korupsi }}: {{ $label_radio_korupsi }}
            </li>
        @endfor
    </ul>

    @if($record->publicForm->remark)
        <div class="remark">
            <h4>Saran dan komentar:</h4>
            {{$record->publicForm->remark}}
        </div>
    @endif

    @if($record->publicForm->signature_path)
        <div class="signature">
            <h4>Signature:</h4>
            <img src="{{ public_path('storage/' . $record->publicForm->signature_path) }}" style="max-width: 150px;">
        </div>
    @endif
</div>

        </div>
    </div>
    
</body>
</html>




