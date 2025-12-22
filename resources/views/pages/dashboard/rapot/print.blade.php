<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapot Santri</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .text-left {
            text-align: left;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .ttd {
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>RAPOT SANTRI PONPES DARUL ULUM</h2>
    <p>
        @if($semester)
            Semester {{ $semester->nama }} {{ $semester->tahun_ajaran }}
        @else
            Semua Semester
        @endif
    </p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th class="text-left">Nama Santri</th>
            <th>NISN</th>
            <th>Akademik</th>
            <th>Akhlak</th>
            <th>Kehadiran</th>
            <th>Rata-rata</th>
            <th>Predikat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rapot as $r)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-left">{{ $r->santri->user->name }}</td>
            <td>{{ $r->santri->nisn }}</td>
            <td>{{ $r->nilai_akademik }}</td>
            <td>{{ $r->nilai_akhlak }}</td>
            <td>{{ $r->kehadiran }}%</td>
            <td>{{ $r->nilai_rata_rata }}</td>
            <td>{{ $r->predikat_akhir }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    <div class="ttd">
        <p>{{ now()->format('d M Y') }}</p>
        <br><br><br>
        <p><strong>Wali Kelas</strong></p>
    </div>
</div>

</body>
</html>
