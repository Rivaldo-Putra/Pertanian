<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kategori Produk</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 40px; font-size: 12px; }
        h1 { text-align: center; color: #16a34a; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #f0f0f0; }
        .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>LAPORAN KATEGORI PRODUK</h1>
    <p style="text-align:center;">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Harga/Kg</th>
                <th>Deskripsi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($categories as $index => $cat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cat->nama_categories }}</td>
                <td>Rp {{ number_format($cat->price) }}</td>
                <td>{{ $cat->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Sistem Pertanian Modern - Rivaldo Candra Putra
    </div>
</body>
</html>
