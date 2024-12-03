<!-- resources/views/success.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Form Berhasil Tersimpan</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Terima kasih telah melakukan pengisian form</p>
                        <div class="text-center">
                            @php
                                $btn_label='';
                                if ($code->files->count() !== 0 || isset($code->external_link)){
                                    $btn_label='dan Unduh File';
                                }

                            @endphp
                            <a href="{{ url('/public/' . $encryptedCodeId) }}" class="btn btn-primary">Lihat Kembali Form</a>
                        </div>
                        <p>
                            <ul>
                                @isset($code->files)
                                @if ($code->files->count() !== 0)
                                    @foreach ($code->files as $files)
                                        <li>
                                            <a href='{{Storage::url($files->file_path)}}' target="_blank" download>Unduh File</a>
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
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
