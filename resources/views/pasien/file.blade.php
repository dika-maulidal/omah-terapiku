<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berkas {{ $data->nama }}</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Berkas Penerima Manfaat: {{ $data->nama }}</h2>
    <p>No. RM: {{ $data->no_rm }} | NIK: {{ $data->nik ?? '-' }}</p>
    <hr>
    @if($data->file_kk)
        <div style="margin-bottom: 20px;">
            <h4>Kartu Keluarga (KK):</h4>
            <a href="{{ $data->getFileKk() }}" target="_blank">Buka Dokumen KK</a>
        </div>
    @endif
    @if($data->file_resume)
        <div style="margin-bottom: 20px;">
            <h4>Surat Resume / Riwayat Berobat Sebelumnya:</h4>
            <a href="{{ $data->getFileResume() }}" target="_blank">Buka Dokumen Resume</a>
        </div>
    @endif
    @if(!$data->file_kk && !$data->file_resume)
        <p>Belum ada berkas yang diunggah.</p>
    @endif
</body>
</html>