<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf_token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Laporan Kontrak</title>

  <link rel="stylesheet" href="{{ public_path('css/laporan.css') }}">
</head>

<body>

  <header>
    <strong><img src="{{ public_path('img/logo_bps.png') }}" alt="BPS Logo" width="10%"></strong>
  </header>


  <h1>Laporan Kontrak Periode {{ \Carbon\Carbon::parse($periode)->translatedFormat('F Y') }}</h1>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Petugas</th>
        <th>Anggaran</th>
        <th>Deskripsi Tugas</th>
        <th>Jumlah Dokumen</th>
        <th>Harga Satuan (Rp.)</th>
        <th>Harga Tot. Tugas (Rp.)</th>
        <th>Total Honor (Rp.)</th>
      </tr>
    </thead>
    <tbody>
      @forelse($laporan as $index => $item)
        @foreach ($item->tugas as $i => $tugas)
          <tr>
            @if ($i == 0)
              <td rowspan="{{ count($item->tugas) }}">{{ $item->nomor_kontrak }}</td>
              <td rowspan="{{ count($item->tugas) }}">
                <ul style="list-style:none; margin:0; padding-left:0;">
                  <li><strong>{{ $item->mitra->nms }}</strong></li>
                  <li>{{ $item->mitra->nama_lengkap }}</li>
                  <li class="italic">{{ $item->mitra->alamat }}</li>
                </ul>
              </td>
            @endif
            <td>
              <ul style="list-style:none; margin:0; padding-left:0;"">
                <li><strong>{{ $tugas->anggaran->kode_anggaran }}</strong></li>
                <li>{{ $tugas->anggaran->nama_kegiatan }}</li>
              </ul>
            </td>
            <td>{{ $tugas->deskripsi_tugas }}</td>
            <td>{{ $tugas->jumlah_dokumen }} {{ $tugas->satuan }}</td>
            <td>{{ number_format($tugas->harga_satuan ?? 0, 0, ',', '.') }}</td>
            <td>{{ number_format($tugas->harga_total_tugas ?? 0, 0, ',', '.') }}</td>

            @if ($i == 0)
              <td rowspan="{{ count($item->tugas) }}">{{ number_format($item->total_honor ?? 0, 0, ',', '.') }}</td>
            @endif
          </tr>
        @endforeach
      @empty
        <tr>
          <td colspan="6" class="text-center">Data tidak tersedia</td>
        </tr>
      @endforelse
    </tbody>
  </table>

</body>

</html>
