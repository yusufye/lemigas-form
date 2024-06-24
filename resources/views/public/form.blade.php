
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .signature-container {
            position: relative;
        }
        .signature-pad {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .clear-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .required-label::after {
            content: "*";
            color: red;
            margin-left: 5px;
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
    @endphp 
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
                <div class="card">
                    <div class="card-header">
                        <p class="text-center fs-2">
                            FORMULIR
                            <br>
                            <strong>{{$code->code}}</strong> 
                        </p>
                        <p class="text-end font-monospace fs-6">
                            <small>{{(isset($form['submitted_at']) ?'Submitted at: '.date('d M Y H:i:s',strtotime($form['submitted_at'])) : '')}}</small>
                        </p>
                       

                    </div>
                    <div class="card-body">
                        <!-- Formulir -->
                        <form id="public-form" action="{{ route('submit-public-form', ['code_id' => $encryptedCodeId]) }}" method="POST">
                            @csrf
                            <!-- Company Name -->
                            
                            <div class="mb-3 p-2">
                                <label for="company_name" class="form-label required-label">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter company name" value="{{ old('company_name') ?? (isset($form['company_name']) ? $form['company_name'] : '') }}" required>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Company Address -->
                            <div class="mb-3 p-2">
                                <label for="company_address" class="form-label required-label">Alamat Perusahan</label>
                                <textarea class="form-control" id="company_address" name="company_address" rows="3" placeholder="Enter company address" required>{{ old('company_address') ?? (isset($form['company_address']) ? $form['company_address'] : '') }}</textarea>
                                @error('company_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Address -->
                            <div class="mb-3 p-2">
                                <label for="company_phone" class="form-label required-label">Telepon/Fax</label>
                                <input type="tel" class="form-control" id="company_phone" name="company_phone" placeholder="Enter company phone/fax" value="{{ old('company_phone') ?? (isset($form['company_phone']) ? $form['company_phone'] : '') }}" required>
                                @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                        <div class="vr"></div>

                            <!-- Kepentingan -->
                        <p class="fs-3">Kepentingan Layanan</p>
                        <p class="fs-6 font-monospace">Seberapa penting menurut Anda mendapatkan aspek layanan tersebut (Importance)?</p>
                        
                        @for($i = 1; $i <= 9; $i++)
                            <div class="mb-3 p-2">
                                @php
                                    // Mendapatkan nilai kepentingan dari array mapping
                                    $label_kepentingan = $input_label[$i];
                                @endphp
                                <label for="kepentingan_{{ $i }}" class="form-label required-label">{{$label_kepentingan}}</label><br>
                                @for($j = 1; $j <= 4; $j++)
                                    @php
                                        // Mendapatkan nilai kepentingan dari array mapping
                                        $label_radio_kepentingan = $radio_label_kepentingan[$j];
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="kepentingan_{{ $i }}_{{ $j }}" name="kepentingan_{{ $i }}" value="{{ $j }}" {{ old("kepentingan_{$i}") == $j ? 'checked' : (isset($form["kepentingan_{$i}"]) ? ($form["kepentingan_{$i}"]==$j?'checked':'') : '') }} required>
                                        <label class="form-check-label" for="kepentingan_{{ $i }}_{{ $j }}">{{ $label_radio_kepentingan }}</label>
                                    </div>
                                @endfor
                                @error("kepentingan_{$i}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endfor

                        <div class="vr"></div>
                        <!-- Kepuasan -->
                        <p class="fs-3">Kepuasan Layanan</p>
                        <p class="fs-6 font-monospace">Serapa puas Anda mendapatkan aspek layanan tersebut (Performance)?</p>
                        
                        @for($i = 1; $i <= 9; $i++)
                            <div class="mb-3 p-2">
                                @php
                                    // Mendapatkan nilai kepentingan dari array mapping
                                    $label_kepuasan = $input_label[$i];
                                @endphp
                                <label for="kepuasan_{{ $i }}" class="form-label required-label">{{$label_kepuasan}}</label><br>
                                @for($j = 1; $j <= 4; $j++)
                                    @php
                                        // Mendapatkan nilai kepentingan dari array mapping
                                        $label_radio_kepuasan = $radio_label[$j];
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="kepuasan_{{ $i }}_{{ $j }}" name="kepuasan_{{ $i }}" value="{{ $j }}" {{ old("kepuasan_{$i}") == $j ? 'checked' : (isset($form["kepuasan_{$i}"]) ? ($form["kepuasan_{$i}"]==$j?'checked':'') : '') }} required>
                                        <label class="form-check-label" for="kepuasan_{{ $i }}_{{ $j }}">{{ $label_radio_kepuasan }}</label>
                                    </div>
                                @endfor
                                @error("kepuasan_{$i}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endfor

                        <div class="vr"></div>
                        <!-- Korupsi -->
                        <h2>Korupsi</h2>
                        @for($i = 1; $i <= 9; $i++)
                            <div class="mb-3 p-2">
                                @php
                                    // Mendapatkan nilai kepentingan dari array mapping
                                    $label_korupsi = $input_label[$i];
                                @endphp
                                <label for="korupsi_{{ $i }}" class="form-label required-label">{{ $label_korupsi }}</label><br>
                                @for($j = 1; $j <= 4; $j++)
                                    @php
                                        // Mendapatkan nilai kepentingan dari array mapping
                                        $label_radio_korupsi = $radio_label[$j];
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="korupsi_{{ $i }}_{{ $j }}" name="korupsi_{{ $i }}" value="{{ $j }}" {{ old("korupsi_{$i}") == $j ? 'checked' : (isset($form["korupsi_{$i}"]) ? ($form["korupsi_{$i}"]==$j?'checked':'') : '') }} required>
                                        <label class="form-check-label" for="korupsi_{{ $i }}_{{ $j }}">{{ $label_radio_korupsi }}</label>
                                    </div>
                                @endfor
                                @error("korupsi_{$i}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endfor
                        
                        <div class="vr"></div>
                        
                        <!-- Remark -->
                        <div class="mb-3 p-2">
                            <label for="remark" class="form-label">Saran dan komentar</label>
                            <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Enter remarks">{{ old('remark') ?? (isset($form['remark']) ? $form['remark'] : '') }}</textarea>
                        </div>
                        
                        <!-- Signature Pad -->
                        <div class="mb-3 p-2">
                            <label for="signature-pad" class="form-label required-label">Tanda tangan</label>
                            <div class="col-sm-12 signature-container">
                                @if(isset($form['submitted_at']) && $form['submitted_at'])
                                    <!-- Tampilkan gambar tanda tangan -->
                                    @if(isset($form['signature_path']) && $form['signature_path'])
                                        <img src="{{asset('storage/'.$form['signature_path'])}}" alt="Signature">
                                    @else
                                        <p class="text-start font-monospace fs-6 p-2">
                                        Signature Not Found !
                                        </p>
                                    @endif
                                @else
                                    <canvas id="signature-pad" class="signature-pad" width="500" height="200"></canvas>
                                    <input type="hidden" name="signature_pad" id="signature-pad-input">
                                    <button type="button" id="clear-signature" class="btn btn-sm btn-outline-danger clear-button" title="Clear Signature">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser" viewBox="0 0 16 16">
                                        <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293z"/>
                                        </svg>
                                    </button>
                                    
                                @endif
                            </div>
                        </div>

                        

                        <input type="hidden" name="code_id" value="{{$code->id}}">

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2z"/>
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
                              </svg>
                            Simpan
                        </button>
                        </form>
                        <!-- Akhir Formulir -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>

        var submittedAt = "{{ (isset($form['submitted_at']) ? $form['submitted_at'] : false) }}";

        const canvas = document.getElementById('signature-pad');
        if (canvas) {
            const signaturePad = new SignaturePad(canvas);

            document.getElementById('clear-signature').addEventListener('click', function () {
                signaturePad.clear();
            });

            document.getElementById('public-form').addEventListener('submit', function (event) {
                if (submittedAt) {
                    event.preventDefault();
                    alert("Data telah tersimpan sebelumnya, tidak dapat mengubah form ini.");
                } else {
                    if (signaturePad.isEmpty()) {
                        event.preventDefault();
                        alert("Silakan tanda tangan terlebih dahulu.");
                    } else {
                        if (!confirm("Apakah anda yakin semua data yang anda simpan sudah sesuai? Form yang sudah disimpan tidak dapat dirubah.")) {
                            event.preventDefault();
                        } else {
                            const dataURL = signaturePad.toDataURL();
                            document.getElementById('signature-pad-input').value = dataURL;
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mengambil nilai dari variabel $submitted_at yang disimpan di halaman Blade
            var submittedAt = "{{ (isset($form['submitted_at']) ? $form['submitted_at'] : false) }}";
    
            // Jika $submitted_at terisi, menonaktifkan semua elemen formulir
            if (submittedAt) {
                // Mengambil semua elemen input, select, textarea, dan tombol dalam formulir
                var inputs = document.querySelectorAll('input, select, textarea, button');
    
                // Mengubah atribut disabled untuk setiap input, select, textarea, dan tombol
                inputs.forEach(function(input) {
                    input.disabled = true;
                });
            }

        });


    </script>
</body>
</html>
