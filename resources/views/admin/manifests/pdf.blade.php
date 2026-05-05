<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Manifest Jamaah Wifa Tour</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #1B4332; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1B4332; color: #D4AF37; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR MANIFEST JAMAAH</h1>
        <p>Di-generate pada: {{ date('d M Y H:i') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Pemesan (Lead)</th>
                <th>Paket Dipilih</th>
                <th>Nama Paspor</th>
                <th>NO. KTP / NIK</th>
                <th>NO. Paspor</th>
                <th>Tgl Lahir</th>
                <th>LP</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($manifests as $i => $m)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $m->order->lead->name ?? '-' }}</td>
                <td>{{ $m->order->package->name ?? '-' }}</td>
                <td>{{ $m->full_name_passport ?? '-' }}</td>
                <td>{{ $m->nik ?? '-' }}</td>
                <td>{{ $m->passport_number ?? '-' }}</td>
                <td>{{ $m->birth_date ? date('d/m/Y', strtotime($m->birth_date)) : '-' }}</td>
                <td>{{ $m->gender ?? '-' }}</td>
                <td>{{ $m->phone ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
