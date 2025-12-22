<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapot Santri</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 3px 0;
            font-size: 12px;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table th {
            background: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            right: 0;
            width: 200px;      
            text-align: center;
        }
    </style>
</head>
<body>
    <img
        src="data:image/png;base64,{{ $logo }}"
        style="
            position: fixed;
            top: 35%;
            left: 20%;
            width: 60%;
            opacity: 0.08;
            z-index: -1000;
        "
    >

    <div class="header">
        <h2>PONDOK PESANTREN DARUL ULUM</h2>
        <p>Desa Bologarang, Kabupaten Grobogan, Jawa Tengah</p>
        <p><strong>RAPOT HASIL BELAJAR SANTRI</strong></p>
    </div>

    <div class="info">
        <p><strong>Nama Santri:</strong> {{ $user->name }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Semester</th>
                <th>Akademik</th>
                <th>Akhlak</th>
                <th>Kehadiran</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rapot as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->semester->nama }} {{ $item->semester->tahun_ajaran }}</td>
                    <td>{{ $item->predikat_akademik }}</td>
                    <td>{{ $item->predikat_akhlak }}</td>
                    <td>{{ $item->predikat_kehadiran }}</td>
                    <td>{{ $item->predikat_akhir }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data rapot tidak tersedia</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br>
        <p><strong>Pimpinan Pondok</strong></p>
    </div>

</body>
</html>
