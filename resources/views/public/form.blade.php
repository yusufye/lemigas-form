
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
        .rating {
        display: inline-block;
        position: relative;
        }

        .rating input {
        display: none; /* Sembunyikan radio input */
        }

        .rating label {
        font-size: 2rem; /* Ukuran bintang */
        color: lightgray; /* Warna default bintang */
        cursor: pointer;
        transition: color 0.2s;
        }

        .rating label:hover,
        .rating label:hover ~ label {
        color: gold; /* Warna bintang saat di-hover */
        }

        .rating input:checked ~ label {
        color: lightgray; /* Reset warna bintang setelah dipilih */
        }

        .rating input:checked + label,
        .rating input:checked + label ~ label {
        color: gold; /* Warna bintang yang dipilih dan sebelumnya */
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

        $radio_label_korupsi=[
            1=>'Tidak Sesuai',
            2=>'Kurang Sesuai',
            3=>'Sesuai',
            4=>'Sangat Sesuai'
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
                        @isset($form['submitted_at'])
                        <p>
                            <small>
                                <ul>
                                    @isset($code->files)
                                    @if ($code->files->count() !== 0)
                                        @foreach ($code->files as $files)
                                            <li>
                                                <a href='{{Storage::url($files->file_path)}}' target="_blank" download>Download File</a>
                                            </li>
                                        @endforeach
                                    @endif
                                        
                                    @endisset
                                    @isset($code->external_link)
                                        <li>
                                            <a href="{{$code->external_link}}" target="_blank">Open Link</a>
                                        </li>
                                    @endisset
                                </ul>
                            </small>
                        </p>
                        @else
                            @if ($code->files->count() !== 0 || isset($code->external_link))
                                <p class="text-center">
                                    <small>
                                        Laporan/Serifikat/Hasil Pengujuan/Kalibrasi/Studi dapat diunduh setelah pengisian survei.
                                    </small>
                                </p>
                            @endif
                        @endisset
                       

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

                            <div class="mb-3 p-2">
                                <label for="jenis_pelayanan" class="form-label required-label">Jenis Pelayanan</label>
                                <select name="jenis_pelayanan" id="jenis_pelayanan" class="form-select">
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='UJI_LAB' ? 'selected' : '') }} value="UJI_LAB" >Uji Lab</option>
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='TENAGA_AHLI' ? 'selected' : '') }} value="TENAGA_AHLI">Tenaga Ahli</option>
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='JASA_STUDI' ? 'selected' : '') }} value="JASA_STUDI">Jasa Studi</option>
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='PENYEWAAN_ALAT' ? 'selected' : '') }} value="PENYEWAAN_ALAT">Penyewaan Alat</option>
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='JASA_BLENDING' ? 'selected' : '') }} value="JASA_BLENDING">Jasa Blending</option>
                                    <option {{ old('jenis_pelayanan') ?? (isset($form['jenis_pelayanan']) && $form['jenis_pelayanan']=='JASA_SERTIFIKASI_PRODUK' ? 'selected' : '') }} value="JASA_SERTIFIKASI_PRODUK">Sasa Sertifikasi Produk</option>
                                </select>
                                @error('jenis_pelayanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 p-2">
                                <label for="responden_age" class="form-label required-label">Usia Responden</label>
                                <input type="number" class="form-control" id="responden_age" name="responden_age" placeholder="Enter Age" value="{{ old('responden_age') ?? (isset($form['responden_age']) ? $form['responden_age'] : '') }}" required>
                                @error('responden_age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 p-2">
                                <label for="responden_gender" class="form-label required-label">Jenis Kelamin Responden</label>
                                <select name="responden_gender" id="responden_gender" class="form-select">
                                    <option {{ old('responden_gender') ?? (isset($form['responden_gender']) && $form['responden_gender']=='MALE' ? 'selected' : '') }} value="MALE"> Pria</option>
                                    <option {{ old('responden_gender') ?? (isset($form['responden_gender']) && $form['responden_gender']=='FEMALE' ? 'selected' : '') }} value="FEMALE">Wanita</option>
                                </select>
                                @error('responden_gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 p-2">
                                <label for="responden_education" class="form-label required-label">Pendidikan Responden</label>
                                <select name="responden_education" id="responden_education" class="form-select">
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='SMP' ? 'selected' : '') }} value="SMP"> SMP</option>
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='SMA' ? 'selected' : '') }} value="SMA">SMA</option>
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='Diploma' ? 'selected' : '') }} value="Diploma">Diploma</option>
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='S1' ? 'selected' : '') }} value="S1">S1</option>
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='S2' ? 'selected' : '') }} value="S2">S2</option>
                                    <option {{ old('responden_education') ?? (isset($form['responden_education']) && $form['responden_education']=='S3' ? 'selected' : '') }} value="S3">S3</option>
                                </select>
                                @error('responden_education')
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
                                    <div class="form-check form-check-inline rating">
                                        <input class="form-check-input" type="radio" id="kepentingan_{{ $i }}_{{ $j }}" name="kepentingan_{{ $i }}" value="{{ $j }}" {{ old("kepentingan_{$i}") == $j ? 'checked' : (isset($form["kepentingan_{$i}"]) ? ($form["kepentingan_{$i}"]==$j?'checked':'') : ($j==4?'checked':'')) }} required>
                                        {{-- <label class="form-check-label" for="kepentingan_{{ $i }}_{{ $j }}">{{ $label_radio_kepentingan }}</label> --}}
                                        <label class="form-check-label" for="kepentingan_{{ $i }}_{{ $j }}">&#9734;</label>
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
                                    <div class="form-check form-check-inline rating">
                                        <input class="form-check-input" type="radio" id="kepuasan_{{ $i }}_{{ $j }}" name="kepuasan_{{ $i }}" value="{{ $j }}" {{ old("kepuasan_{$i}") == $j ? 'checked' : (isset($form["kepuasan_{$i}"]) ? ($form["kepuasan_{$i}"]==$j?'checked':'') : ($j==4?'checked':'')) }} required>
                                        {{-- <label class="form-check-label" for="kepuasan_{{ $i }}_{{ $j }}">{{ $label_radio_kepuasan }}</label> --}}
                                        <label class="form-check-label" for="kepuasan_{{ $i }}_{{ $j }}">&#9734;</label>
                                    </div>
                                @endfor
                                @error("kepuasan_{$i}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endfor

                        <div class="vr"></div>
                        <!-- Korupsi -->
                        <h2>Persepsi Korupsi</h2>
                        @for($i = 1; $i <= 9; $i++)
                            <div class="mb-3 p-2">
                                @php
                                    // Mendapatkan nilai kepentingan dari array mapping
                                    $label_korupsi = $input_label_korupsi[$i];
                                @endphp
                                <label for="korupsi_{{ $i }}" class="form-label required-label">{{ $label_korupsi }}</label><br>
                                @for($j = 1; $j <= 4; $j++)
                                    @php
                                        // Mendapatkan nilai kepentingan dari array mapping
                                        $label_radio_korupsi = $radio_label_korupsi[$j];
                                    @endphp
                                    <div class="form-check form-check-inline rating">
                                        <input class="form-check-input" type="radio" id="korupsi_{{ $i }}_{{ $j }}" name="korupsi_{{ $i }}" value="{{ $j }}" {{ old("korupsi_{$i}") == $j ? 'checked' : (isset($form["korupsi_{$i}"]) ? ($form["korupsi_{$i}"]==$j?'checked':'') : ($j==4?'checked':'')) }} required>
                                        {{-- <label class="form-check-label" for="korupsi_{{ $i }}_{{ $j }}">{{ $label_radio_korupsi }}</label> --}}
                                        <label class="form-check-label" for="korupsi_{{ $i }}_{{ $j }}">&#9734;</label>
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


                        <div class="mb-3 p-2">
                            <label for="complaint" class="form-label">Saran dan Pengaduan</label>
                            <textarea class="form-control" id="complaint" name="complaint" rows="3" placeholder="Enter complaints">{{ old('complaint') ?? (isset($form['complaint']) ? $form['complaint'] : '') }}</textarea>
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

 // Fungsi untuk memberi rating default sesuai dengan radio yang sudah "checked"
function setDefaultRating() {
  document.querySelectorAll('.rating input:checked').forEach((radio) => {
    const name = radio.name; // Dapatkan nama grup input
    const selectedValue = parseInt(radio.value); // Nilai checked pada grup

    // Perbarui semua label pada grup terkait
    document.querySelectorAll(`input[name="${name}"]`).forEach((input) => {
      const label = input.nextElementSibling; // Label terkait
      const inputValue = parseInt(input.value);

      if (inputValue <= selectedValue) {
        // Warnai bintang hingga nilai checked
        label.textContent = '★';
        label.style.color = 'gold';
      } else {
        // Reset warna bintang setelah nilai checked
        label.textContent = '★';
        label.style.color = 'lightgray';
      }
    });
  });
}

// Fungsi untuk menangani perubahan rating
function handleRatingChange() {
  document.querySelectorAll('.rating input').forEach((radio) => {
    radio.addEventListener('change', (event) => {
      const name = event.target.name; // Dapatkan nama grup input
      const selectedValue = parseInt(event.target.value); // Nilai yang dipilih

      // Perbarui semua label pada grup terkait
      document.querySelectorAll(`input[name="${name}"]`).forEach((input) => {
        const label = input.nextElementSibling; // Label terkait
        const inputValue = parseInt(input.value);

        if (inputValue <= selectedValue) {
          // Warnai bintang hingga nilai yang dipilih
          label.textContent = '★';
          label.style.color = 'gold';
        } else {
          // Reset warna bintang setelah nilai yang dipilih
          label.textContent = '★';
          label.style.color = 'lightgray';
        }
      });

      console.log(`Rating selected for ${name}: ${selectedValue}`);
    });
  });
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
  setDefaultRating(); // Atur rating default berdasarkan "checked"
  handleRatingChange(); // Tambahkan event listener untuk perubahan rating
});







    </script>
</body>
</html>
