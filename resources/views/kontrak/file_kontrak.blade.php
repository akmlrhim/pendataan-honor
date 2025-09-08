<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Perjanjian Kerja - BPS Kabupaten Tapin</title>
  <style>
    body {
      font-family: 'Bookman Old Style', serif;
      line-height: 1.3;
      margin: 12px;
    }

    p {
      margin: 4px 0;
    }

    .center {
      text-align: center;
    }

    .bold {
      font-weight: bold;
    }

    .underline {
      text-decoration: underline;
    }

    .header,
    .sub-header {
      text-align: center;
      font-weight: bold;
      line-height: 1.2;
    }

    .header p,
    .sub-header p {
      margin: 2px 0;
    }

    .nomor-surat {
      text-align: center;
    }

    .content {
      text-align: justify;
    }

    .pasal {
      text-align: center;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 5px;
      margin-bottom: 5px;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 4px;
      text-align: left;
    }

    .signature-section {
      margin-top: 30px;
      text-align: center;
    }

    .signature-space {
      height: 50px;
    }

    .signature {
      width: 45%;
    }

    .uppercase {
      text-transform: uppercase
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>

  {{-- perjanjian kerja  --}}
  <div class="header">
    <p class="bold">PERJANJIAN KERJA</p>
    <p class="bold uppercase">PETUGAS {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} DATA SURVEI</p>
    <p class="bold uppercase">KEGIATAN BULAN {{ $kontrak->created_at->translatedFormat('F') }}
      {{ $kontrak->created_at->format('Y') }}
    </p>
    <p class="bold">BADAN PUSAT STATISTIK KABUPATEN TAPIN</p>
  </div>
  <p class="nomor-surat">NOMOR:
    {{ $kontrak->nomor_kontrak }}/SPK/63051/KP.200/{{ $kontrak->created_at->format('m') }}/{{ $kontrak->created_at->format('Y') }}
  </p>
  <br>
  <div class="content">
    <p>Pada hari ini, {{ $kontrak->tanggal_kontrak_terbilang }}, bertempat di kantor Badan
      Pusat Statistik Kabupaten Tapin Jalan Haryono MT Rantau, yang bertanda tangan di bawah ini:</p>
    <table style="border: none">
      <tr style="border: none;">
        <td style="border: none; width: 15%;">Warkani, SE</td>
        <td style="border: none; width: 5%;">:</td>
        <td style="border: none;">Pejabat Pembuat Komitmen Badan Pusat Statistik Kabupaten Tapin, berkedudukan di Jl.
          Haryono MT Rantau, bertindak untuk dan atas nama Badan Pusat Statistik Kabupaten Tapin, selanjutnya disebut
          sebagai <span class="bold">PIHAK PERTAMA</span>.</td>
      </tr>
      <tr style="border: none;">
        <td style="border: none;">{{ $kontrak->mitra->nama_lengkap }}</td>
        <td style="border: none;">:</td>
        <td style="border: none;">Petugas {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} Data Survei,
          berkedudukan di Perintis Raya Kabupaten Tapin,
          bertindak untuk dan atas nama diri sendiri, selanjutnya disebut sebagai <span class="bold">PIHAK
            KEDUA</span>.</td>
      </tr>
    </table>
    <p>bahwa <span class="bold">PIHAK PERTAMA</span> dan <span class="bold">PIHAK KEDUA</span> yang secara
      bersama-sama disebut <span class="bold">PARA PIHAK</span>, sepakat untuk mengikatkan diri dalam Perjanjian Kerja
      Petugas {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} Data Survei di Badan Pusat Statistik Kabupaten
      Tapin, yang selanjutnya disebut Perjanjian,
      dengan ketentuan-ketentuan sebagai berikut:</p>

    {{-- pasal 1 --}}
    <p class="pasal">Pasal 1</p>
    <p><span class="bold">PIHAK PERTAMA</span> memberikan pekerjaan kepada <span class="bold">PIHAK KEDUA</span> dan
      <span class="bold">PIHAK KEDUA</span> menerima pekerjaan dari <span class="bold">PIHAK PERTAMA</span> sebagai
      Petugas {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} Data Survei dengan lingkup pekerjaan yang
      ditetapkan oleh <span class="bold">PIHAK
        PERTAMA</span>.
    </p>

    {{-- pasal 2 --}}
    <p class="pasal">Pasal 2</p>
    <ol type="(1)">
      <li>
        Lingkup pekerjaan dalam Perjanjian ini mengacu pada alokasi tugas, dan ketentuan-ketentuan yang ditetapkan oleh
        <span class="bold">PIHAK PERTAMA</span>.
      </li>
      <li>
        Alokasi tugas dalam Pasal 2 ayat 1 ditetapkan oleh <span class="bold">PIHAK PERTAMA</span> sebagai bagian yang
        tidak terpisahkan dari surat perjanjian ini.
      </li>
      <li>
        <span class="bold">PIHAK PERTAMA</span> melaksanakan evaluasi atas alokasi tugas surat perjanjian ini.
      </li>
      <li>
        <span class="bold">PIHAK KEDUA</span> melaksanakan alokasi tugas dan
        perubahan-perubahannya yang ditetapkan oleh
        <span class="bold">PIHAK PERTAMA</span>.
      </li>
    </ol>

    {{-- pasal 3 --}}
    <p class="pasal">Pasal 3</p>
    <p>Pelaksanaan pekerjaan pada Perjanjian ini, dilakukan melalui:</p>
    <ol type="a">
      <li>
        Penyelesaian pekerjaan di lingkungan kantor BPS; <span class="bold">PIHAK KEDUA</span> wajib mentaati
        ketentuan jam kerja, pakaian, penggunaan sistem presensi, dan segala ketentuan yang diberlakukan oleh <span
          class="bold">PIHAK PERTAMA</span>.
      </li>
      <li>
        Penyelesaian pekerjaan di luar lingkungan kantor BPS; <span class="bold">PIHAK KEDUA</span> wajib menyerahkan
        pekerjaan yang telah diselesaikan sesuai dengan target yang ditentukan oleh <span class="bold">PIHAK
          PERTAMA</span>.
      </li>
    </ol>

    <br />

    {{-- pasal 4 --}}
    <p class="pasal">Pasal 4</p>
    <ol type="1">
      <li> Jangka waktu Perjanjian ini terhitung selama satu bulan terhitung sejak tanggal
        {{ $kontrak->tanggal_mulai->translatedFormat('d F Y') }} sampai dengan tanggal
        {{ $kontrak->tanggal_berakhir->translatedFormat('d F Y') }}.
      </li>

      <li>Dikecualikan sebagaimana diatur pada ayat (1), apabila dari hasil evaluasi sebagaimana Pasal 2 ayat (3)
        dianggap tidak layak sebagai petugas Pengumpulan Data Survei, maka <span class="bold">PIHAK PERTAMA</span>
        dapat mengakhiri perjanjian ini secara sepihak.
      </li>
    </ol>

    {{-- pasal 5 --}}
    <p class="pasal">Pasal 5</p>
    <ol type="1">
      <li>
        <span class="bold">PIHAK KEDUA</span> berkewajiban menyelesaikan seluruh pekerjaan yang diberikan oleh <span
          class="bold">PIHAK PERTAMA</span> sesuai ruang lingkup pekerjaan sebagaimana dimaksud dalam Pasal 2.
      </li>
      <li>
        <span class="bold">PIHAK KEDUA</span> untuk waktu yang tidak terbatas dan/atau tidak terikat kepada masa
        berlakunya Perjanjian ini, menjamin untuk memberlakukan sebagai rahasia setiap data/informasi yang diterima atau
        diperolehnya, serta menjamin bahwa keterangan demikian hanya dipergunakan untuk melaksanakan tujuan menurut
        Perjanjian ini.</p>
      </li>
    </ol>

    {{-- pasal 6 --}}
    <p class="pasal">Pasal 6</p>
    <ol type="1">
      <li>
        <span class="bold">PIHAK KEDUA</span> apabila melakukan peminjaman dokumen/data/aset milik <span
          class="bold">PIHAK PERTAMA</span>, wajib menjaga dan menggunakan sesuai dengan tujuan perjanjian dan
        mengembalikan dalam keadaan utuh sama dengan saat peminjaman, serta dilarang menggandakan, menyalin, dan/atau
        mendokumentasikan dalam bentuk foto atau bentuk apapun untuk kepentingan pribadi ataupun kepentingan lain yang
        tidak berkaitan dengan tujuan perjanjian ini.
      </li>
      <li>
        <span class="bold">PIHAK KEDUA</span> dilarang memberikan
        dokumen/data/asset milik <span class="bold">PIHAK PERTAMA</span> yang berada dalam penguasaan <span
          class="bold">PIHAK KEDUA</span>, baik secara langsung maupun tidak langsung, termasuk memberikan akses
        kepada
        pihak lain untuk menggunakan, menyalin, memfotokopi, dan/atau mendokumentasikan dalam bentuk foto atau bentuk
        apapun, sehingga informasi diketahui oleh pihak lain untuk tujuan apapun.
      </li>
    </ol>

    {{-- pasal 7 --}}
    <p class="pasal">Pasal 7</p>
    <ol type="1">
      <li>
        <span class="bold">PIHAK KEDUA</span> berhak untuk mendapatkan honorarium dari <span class="bold">PIHAK
          PERTAMA</span> maksimal sebesar <span
          class="bold">Rp{{ number_format($kontrak->total_honor, 0, ',', ',') }}.-
          ({{ $kontrak->total_honor_terbilang }})</span> dengan alokasi beban kerja seperti terlampir, sudah termasuk
        uang transport (kecuali jika wilayah kerjanya merupakan daerah sulit), uang makan, biaya pajak, bea materai,
        pulsa dan kuota internet untuk komunikasi, dan jasa pelayanan keuangan.
      </li>
      <li>
        Pembayaran honorarium sebagaimana ayat (1) dilakukan setelah seluruh pekerjaan diselesaikan yang
        dibuktikan dengan Berita Acara Serah Terima.
      </li>
      <li>
        Dikecualikan sebagaimana diatur pada ayat 1, apabila <span class="bold">PIHAK KEDUA</span> tidak dapat
        menyelesaikan pekerjaan sesuai alokasi beban, maka <span class="bold">PIHAK PERTAMA</span> membayarkan
        honorarium kepada <span class="bold">PIHAK KEDUA</span> sesuai pekerjaan yang telah diselesaikan dengan
        melampirkan keterangan dan bukti dukungnya bila ada bagian pekerjaan yang belum diselesaikan.
      </li>
    </ol>

    {{-- pasal 8 --}}
    <p class="pasal">Pasal 8</p>
    <p>Pembayaran honorarium sebagaimana dimaksud dalam Pasal 7, dilakukan setelah <span class="bold">PIHAK
        KEDUA</span> menyerahkan seluruh hasil pekerjaan yang telah diselesaikan kepada <span class="bold">PIHAK
        PERTAMA</span> atau seperti yang disebutkan dalam pasal 7 ayat 3. Pembayaran honorarium dilaksanakan pada bulan
      berikutnya setelah bulan pelaksanaan pekerjaan.</p>

    {{-- pasal 9 --}}
    <p class="pasal">Pasal 9</p>
    <p><span class="bold">PIHAK PERTAMA</span> melakukan evaluasi atas target penyelesaian pekerjaan dan kualitas
      hasil {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} Data Survei yang dilaksanakan oleh <span
        class="bold">PIHAK KEDUA</span> secara berkala setiap
      minggu.</p>

    {{-- Pasal 10  --}}
    <p class="pasal">Pasal 10</p>
    <p>Penyerahan seluruh hasil pekerjaan yang dilaksanakan oleh <span class="bold">PIHAK KEDUA</span> kepada <span
        class="bold">PIHAK PERTAMA</span> dinyatakan dalam Berita Acara Serah Terima Hasil Pekerjaan dan
      ditandatangani oleh <span class="bold">PARA PIHAK</span> selambat-lambatnya sesuai jangka waktu Perjanjian.</p>

    {{-- Pasal 11 --}}
    <p class="pasal">Pasal 11</p>
    <p><span class="bold">PIHAK PERTAMA</span> dapat mengakhiri Perjanjian ini secara sepihak sewaktu-waktu apabila
      <span class="bold">PIHAK KEDUA</span> tidak dapat melaksanakan kewajibannya sebagaimana dimaksud dalam
      Perjanjian ini.
    </p>

    {{-- Pasal 12 --}}
    <p class="pasal">Pasal 12</p>
    <ol type="1">
      <li>
        Apabila <span class="bold">PIHAK KEDUA</span> mengundurkan diri dengan tidak menyelesaikan pekerjaan yang
        menjadi tanggung jawabnya, maka dikenakan sanksi administratif dikeluarkan dari daftar Mitra Statistik dan wajib
        membayar ganti rugi kepada <span class="bold">PIHAK PERTAMA</span> sebesar biaya yang sudah dikeluarkan untuk
        pelatihan/briefing.
      </li>
      <li>
        Dikecualikan tidak membayar ganti rugi sebagaimana dimaksud pada ayat (1) kepada <span class="bold">PIHAK
          PERTAMA</span>, apabila <span class="bold">PIHAK KEDUA</span> meninggal dunia, mengundurkan diri karena
        sakit dengan keterangan rawat inap, dan/atau telah diberikan Surat Pemutusan Perjanjian
        Kerja dari <span class="bold">PIHAK PERTAMA</span>.
      </li>
      <li>alam hal terjadi peristiwa sebagaimana dimaksud pada ayat (2), <span class="bold">PIHAK PERTAMA</span>
        membayarkan honorarium kepada <span class="bold">PIHAK KEDUA</span> sesuai pekerjaan yang telah diselesaikan
        dinyatakan dengan surat keterangan oleh kepala satuan kerja. </li>
      <li>
        Apabila <span class="bold">PIHAK KEDUA</span> melanggar ketentuan dalam Pasal 6 perjanjian ini, akan
        diberhentikan dengan membayar denda dan diberikan sanksi sesuai ketentuan peraturan perundang-undangan.
      </li>
    </ol>

    {{-- pasal 13 --}}
    <p class="pasal">Pasal 13</p>
    <ol type="1">
      <li>
        Apabila terjadi Keadaan Kahar, yang meliputi bencana alam dan bencana sosial, <span class="bold">PIHAK
          KEDUA</span> memberitahukan kepada <span class="bold">PIHAK PERTAMA</span> dalam waktu paling lambat 7
        (tujuh) hari sejak mengetahui atas kejadian Keadaan Kahar dengan menyertakan bukti.
      </li>
      <li>
        Pada saat terjadi Keadaan Kahar, pelaksanaan pekerjaan oleh <span class="bold">PIHAK KEDUA</span> dihentikan
        sementara dan dilanjutkan kembali setelah Keadaan Kahar berakhir, namun apabila akibat Keadaan Kahar tidak
        memungkinkan dilanjutkan/diselesaikannya pelaksanaan pekerjaan, <span class="bold">PIHAK KEDUA</span> berhak
        menerima honorarium sesuai pekerjaan yang telah diselesaikan.
      </li>
    </ol>

    {{-- pasal 14 --}}
    <p class="pasal">Pasal 14</p>
    <ol>
      <li>
        Segala perselisihan yang mungkin timbul sebagai akibat dari Perjanjian ini, diselesaikan secara musyawarah untuk
        mufakat oleh <span class="bold">PARA PIHAK</span>.
      </li>
      <li>
        Apabila musyawarah untuk mufakat sebagaimana dimaksud pada ayat (1) tidak berhasil, maka <span
          class="bold">PARA PIHAK</span> sepakat untuk menyelesaikan melalui Kepaniteraan Pengadilan Negeri Rantau.
      </li>
      <li>
        Selama perselisihan dalam proses penyelesaian pengadilan, <span class="bold">PIHAK PERTAMA</span> dan <span
          class="bold">PIHAK KEDUA</span> wajib tetap melaksanakan kewajiban masing-masing berdasarkan Perjanjian
        ini.
      </li>
    </ol>

    {{-- pasal 15  --}}
    <p class="pasal">Pasal 15</p>
    <p>Hal-hal yang belum diatur dalam Perjanjian ini atau segala perubahan terhadap Perjanjian ini diatur lebih lanjut
      oleh <span class="bold">PARA PIHAK</span> dalam perjanjian tambahan/adendum dan merupakan bagian tidak
      terpisahkan dari Perjanjian ini.</p>

    <p>Demikian Perjanjian ini dibuat dan ditandatangani oleh <span class="bold">PARA PIHAK</span> dalam 2 (dua)
      rangkap asli bermeterai cukup, tanpa paksaan dari <span class="bold">PIHAK</span> manapun dan untuk
      dilaksanakan
      oleh <span class="bold">PARA PIHAK</span>.</p>
  </div>

  <div style="text-align:center; margin-top:50px;">
    <table style="width:80%; margin:0 auto; border:none;">
      <tr style="border:none;">
        <td style="border:none; width:50%; text-align:center;">
          PIHAK KEDUA,<br><br><br><br>
          <span class="bold underline">{{ $kontrak->mitra->nama_lengkap }}</span>
        </td>
        <td style="border:none; width:50%; text-align:center;">
          PIHAK PERTAMA,<br><br><br><br>
          <span class="bold underline">Warkani, SE</span>
        </td>
      </tr>
    </table>
  </div>



  <div class="page-break"></div>

  {{-- alokasi  --}}
  <div class="sub-header">
    <p class="bold uppercase">ALOKASI TUGAS {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} DATA SURVEI</p>
    <p class="bold uppercase">BULAN {{ $kontrak->created_at->translatedFormat('F') }}
      {{ $kontrak->created_at->format('Y') }} BPS KABUPATEN TAPIN</p>
  </div>
  <br>
  <table style="border: none">
    <tr style="border: none;">
      <td style="border: none; width: 25%;">NAMA</td>
      <td style="border: none; width: 5%;">:</td>
      <td style="border: none;">{{ $kontrak->mitra->nama_lengkap }}</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;">No. SURAT PERJANJIAN</td>
      <td style="border: none;">:</td>
      <td style="border: none;">
        {{ $kontrak->nomor_kontrak }}/SPK/63051/KP.630/{{ $kontrak->created_at->format('m') }}/{{ $kontrak->created_at->format('Y') }}
      </td>
    </tr>
  </table>

  <table style="font-size:12px">
    <thead>
      <tr>
        <th>No.</th>
        <th>Kode Mata Anggaran</th>
        <th>Uraian/Detail Akun</th>
        <th>Volume</th>
        <th>Satuan (Rp)</th>
        <th>Total (Rp)</th>
        <th>Keterangan</th>
      </tr>
      <tr>
        <th class="center">(1)</th>
        <th class="center">(2)</th>
        <th class="center">(3)</th>
        <th class="center">(4)</th>
        <th class="center">(5)</th>
        <th class="center">(6)</th>
        <th class="center">(7)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kontrak->tugas as $index => $item)
        <tr>
          <td class="center">{{ $index + 1 }}</td>
          <td>{{ $item->anggaran->kode_anggaran }}</td>
          <td>{{ $item->deskripsi_tugas }}</td>
          <td class="center">{{ $item->jumlah_dokumen }} {{ $item->satuan }}</td>
          <td>{{ 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') }}
          </td>
          <td style="text-align: right;">{{ 'Rp ' . number_format($item->harga_total_tugas, 0, ',', '.') }}</td>
          <td style="text-align: right;"></td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="bold" style="text-align: center;">TOTAL KESELURUHAN</td>
        <td colspan="5" class="bold" style="text-align: right;">
          Rp{{ number_format($kontrak->total_honor, 0, ',', ',') }}.-
          ({{ $kontrak->total_honor_terbilang }})
        </td>
      </tr>
    </tfoot>
  </table>
  <div style="text-align:center; margin-top:50px;">
    <table style="width:80%; margin:0 auto; border:none;">
      <tr style="border:none;">
        <td style="border:none; width:50%; text-align:center;">
          PIHAK KEDUA,<br><br><br><br>
          <span class="bold underline">{{ $kontrak->mitra->nama_lengkap }}</span>
        </td>
        <td style="border:none; width:50%; text-align:center;">
          PIHAK PERTAMA,<br><br><br><br>
          <span class="bold underline">Warkani, SE</span>
        </td>
      </tr>
    </table>
  </div>
  <div class="page-break"></div>


  {{-- berita acara serah terima  --}}
  <div class="header">
    <p class="bold">BERITA ACARA SERAH TERIMA PEKERJAAN</p>
    <p class="bold uppercase">{{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} DATA SURVEI</p>
    <p class="bold uppercase">KEGIATAN BULAN {{ $kontrak->created_at->translatedFormat('F') }}
      {{ $kontrak->created_at->format('Y') }}</p>
    <p class="bold">BADAN PUSAT STATISTIK KABUPATEN TAPIN</p>
  </div>
  <p class="nomor-surat">NOMOR:
    {{ $kontrak->nomor_kontrak }}/BAST/63051/KP.200/{{ $kontrak->created_at->format('Y') }}</p>
  <br>
  <div class="content">
    <p>Pada hari ini {{ $kontrak->tanggal_kontrak_terbilang }} ({{ $kontrak->created_at->format('d/m/Y') }}),
      bertempat
      di
      Kantor BPS Kabupaten Tapin dengan alamat Jalan Haryono MT Rantau, yang bertanda tangan di bawah ini:</p>
    <table style="border: none;">
      <tr style="border: none;">
        <td style="border: none; width: 20%;">Warkani, SE</td>
        <td style="border: none; width: 5%;">:</td>
        <td style="border: none;">Pejabat Pembuat Komitmen Badan Pusat Statistik BPS Kabupaten Tapin, alamat Jl.
          Haryono MT Rantau bertindak untuk dan atas nama Badan Pusat Statistik BPS Kabupaten Tapin selanjutnya disebut
          <span class="bold">PIHAK PERTAMA</span>.
        </td>
      </tr>
      <tr style="border: none;">
        <td style="border: none;">{{ $kontrak->mitra->nama_lengkap }}</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ ucfirst($kontrak->tugas->first()->anggaran->nama_kegiatan) }} Data Survei,
          berkedudukan di Perintis Raya Kabupaten Tapin, bertindak untuk dan atas nama diri sendiri, selanjutnya disebut
          sebagai <span class="bold">PIHAK KEDUA</span>.
        </td>
      </tr>
    </table>
    <p>Berdasarkan Surat Perjanjian Kerja (SPK) Nomor:
      {{ $kontrak->nomor_kontrak }}/SPK/63051/KP.200/{{ $kontrak->created_at->format('m') }}/{{ $kontrak->created_at->format('Y') }},
      {{ $kontrak->tanggal_kontrak->translatedFormat('d F Y') }}, bersama ini PIHAK KEDUA telah menyerahkan hasil
      pekerjaan {{ ucfirst($kontrak->tugas->first()->anggaran->nama_kegiatan) }} Data Survei Kegiatan Bulan <span
        class="uppercase">{{ $kontrak->created_at->translatedFormat('F') }}</span>
      {{ $kontrak->created_at->format('Y') }} di Kabupaten Tapin kepada PIHAK PERTAMA, dengan ketentuan sebagai
      berikut:
    </p>
    <ol type="a">
      <li>
        Hasil pekerjaan PIHAK KEDUA telah sesuai dengan jumlah dan spesifikasi teknis/kualitas yang ditetapkan dalam
        SPK.
      </li>
      <li>
        Hasil pekerjaan sebagaimana tersebut pada huruf a telah diperiksa oleh Petugas Pengawas, dan diterima
        kelengkapannya oleh PIHAK PERTAMA.
      </li>
    </ol>
    <p>Demikian Berita Acara ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
  </div>

  <div style="text-align:center; margin-top:50px;">
    <table style="width:80%; margin:0 auto; border:none;">
      <tr style="border:none;">
        <td style="border:none; width:50%; text-align:center;">
          PIHAK KEDUA,<br><br><br><br>
          <span class="bold underline">{{ $kontrak->mitra->nama_lengkap }}</span>
        </td>
        <td style="border:none; width:50%; text-align:center;">
          PIHAK PERTAMA,<br><br><br><br>
          <span class="bold underline">Warkani, SE</span>
        </td>
      </tr>
    </table>
  </div>


  <div style="clear: both; text-align: center; margin-top: 50px;">
    <p>Mengetahui,</p>
    <p>Kepala BPS Kabupaten Tapin</p>
    <div class="signature-space"></div>
    <p class="bold underline">Rudy Nooryadi, S.Si. ME</p>
  </div>

  <div class="page-break"></div>

  {{-- Realisasi kegiatan  --}}
  <div class="sub-header">
    <p class="bold uppercase">
      REALISASI KEGIATAN {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} DATA SURVEI
    </p>
    <p class="bold uppercase">BULAN {{ $kontrak->created_at->translatedFormat('F') }}
      {{ $kontrak->created_at->format('Y') }} BPS KABUPATEN TAPIN
    </p>
  </div>
  <br>
  <table style="border: none">
    <tr style="border: none;">
      <td style="border: none; width: 25%;">NAMA</td>
      <td style="border: none; width: 5%;">:</td>
      <td style="border: none;">{{ $kontrak->mitra->nama_lengkap }}</td>
    </tr>
    <tr style="border: none;">
      <td style="border: none;">No. SURAT PERJANJIAN</td>
      <td style="border: none;">:</td>
      <td style="border: none;">
        {{ $kontrak->nomor_kontrak }}/SPK/63051/KP.200/{{ $kontrak->created_at->format('m') }}/{{ $kontrak->created_at->format('Y') }}
      </td>
    </tr>
  </table>

  <table style="font-size:12px">
    <thead>
      <tr>
        <th>No.</th>
        <th>Kode Mata Anggaran</th>
        <th>Uraian/Detail Akun</th>
        <th>Volume Target</th>
        <th>Volume Realisasi</th>
        <th>Rekomendasi</th>
      </tr>
      <tr>
        <th class="center">(1)</th>
        <th class="center">(2)</th>
        <th class="center">(3)</th>
        <th class="center">(4)</th>
        <th class="center">(5)</th>
        <th class="center">(6)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kontrak->tugas as $index => $item)
        <tr>
          <td class="center">{{ $index + 1 }}</td>
          <td>{{ $item->anggaran->kode_anggaran }}</td>
          <td>{{ $item->deskripsi_tugas }}</td>
          <td class="center">{{ $item->jumlah_target_dokumen }} {{ $item->satuan }}</td>
          <td class="center">{{ $item->jumlah_dokumen }} {{ $item->satuan }}</td>
          <td></td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="bold" style="text-align: center;">PERSENTASE PENYELESAIAN PEKERJAAN</td>
        <td class="bold center" colspan="2">
          {{ number_format(($kontrak->tugas->sum('jumlah_dokumen') / $kontrak->tugas->sum('jumlah_target_dokumen')) * 100, 1) }}%
        </td>
      </tr>
    </tfoot>
  </table>
  <div style="text-align:center; margin-top:50px;">
    <table style="width:80%; margin:0 auto; border:none;">
      <tr style="border:none;">
        <td style="border:none; width:50%; text-align:center;">
          <!-- Kosong untuk pihak kedua -->
        </td>
        <td style="border:none; width:50%; text-align:center;">
          Rantau, {{ $kontrak->tanggal_surat->format('d F Y') }}
        </td>
      </tr>
      <tr style="border:none;">
        <td style="border:none; width:50%; text-align:center;" class="bold">
          PIHAK KEDUA,<br><br><br><br>
          <span class="bold">{{ $kontrak->mitra->nama_lengkap }}</span>
        </td>
        <td style="border:none; width:50%; text-align:center;" class="bold">
          PIHAK PERTAMA,<br><br><br><br>
          <span class="bold">Warkani, SE</span>
        </td>
      </tr>
    </table>
  </div>


  <div class="page-break"></div>

  {{-- Fakta integritas  --}}
  <div class="header">
    <p class="bold underline">PAKTA INTEGRITAS</p>
  </div>
  <br>
  <div class="content">
    <p>Saya yang bertanda tangan dibawah ini :</p>
    <table style="border: none; width: 80%;">
      <tr style="border: none;">
        <td style="border: none; width: 15%;">Nama</td>
        <td style="border: none; width: 5%;">:</td>
        <td style="border: none;">{{ $kontrak->mitra->nama_lengkap }}</td>
      </tr>
      <tr style="border: none;">
        <td style="border: none;">NMS</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ $kontrak->mitra->nms }}</td>
      </tr>
    </table>
    <p>Bertindak untuk dan atas nama Mitra Statistik BPS Kabupaten Tapin</p>
    <p>Sehubungan dengan pelaksanaan kegiatan {{ $kontrak->tugas->first()->anggaran->nama_kegiatan }} data
      Sensus/Survei* TA {{ date('Y') }} bulan : <span
        class="uppercase">{{ $kontrak->created_at->translatedFormat('F') }}</span>
      {{ $kontrak->created_at->format('Y') }},
      dengan ini saya
      menyatakan bahwa :</p>
    <ol>
      <li>Menjaga kerahasian data yang menjadi tugas dan tanggung jawab;</li>
      <li>Menjalankan tugas sesuai dengan ketentuan dan SOP pelaksanaan lapangan.</li>
      <li>Tidak akan melakukan praktek Korupsi, kolusi dan Nepotisme;</li>
      <li>Apabila melanggar hal-hal yang dinyatakan dalam PAKTA INTEGRITAS ini, besedia menerima sanksi administratif,
        digugat secara perdata dan/atau dilaporkan secara pidana.</li>
    </ol>
  </div>
  <div style="width: 30%; float: right; text-align: center; margin-top: 30px;">
    <p>Rantau, {{ $kontrak->tanggal_kontrak->format('d F Y') }}</p>
    <p>Mitra Statistik</p>
    <div class="signature-space"></div>
    <p class="bold underline">{{ $kontrak->mitra->nama_lengkap }}</p>
  </div>
</body>

</html>
