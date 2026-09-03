<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berkas {{ $data->nama }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 28px; background: #f8fafc; color: #1e293b; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; max-width: 650px; margin: 0 auto; box-shadow: 0 4px 18px rgba(46,75,130,0.06); }
        h2 { color: #1e40af; margin-top: 0; font-size: 20px; }
        .btn-doc { display: inline-block; padding: 8px 16px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 13px; margin-top: 6px; }
        .btn-doc:hover { background: #1d4ed8; }
        .badge { background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 13px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Berkas Penerima Manfaat: {{ $data->nama }}</h2>
        <p style="color: #64748b; font-size: 13.5px;">No. RM: <span class="badge">{{ $data->no_rm }}</span> | NIK: <strong>{{ $data->nik ?? '-' }}</strong></p>
        <hr style="border: none; border-top: 1px solid #edf2f7; margin: 20px 0;">
        @if($data->file_kk)
            <div style="margin-bottom: 20px;">
                <h4 style="margin-bottom: 4px; color: #334155; font-size: 15px;">Kartu Keluarga (KK):</h4>
                <a href="{{ $data->getFileKk() }}" target="_blank" class="btn-doc">Buka Dokumen KK</a>
            </div>
        @endif
        @if($data->file_resume)
            <div style="margin-bottom: 20px;">
                <h4 style="margin-bottom: 4px; color: #334155; font-size: 15px;">Surat Resume / Riwayat Berobat Sebelumnya:</h4>
                <a href="{{ $data->getFileResume() }}" target="_blank" class="btn-doc">Buka Dokumen Resume</a>
            </div>
        @endif
        @if(!$data->file_kk && !$data->file_resume)
            <p style="color: #94a3b8; font-size: 13.5px;">Belum ada berkas yang diunggah.</p>
        @endif
    </div>
</body>
</html>