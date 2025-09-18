@extends('layouts.template')

@section('content')
  <div class="row">
    {{-- data mitra  --}}
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="card-title">Data Mitra</h5>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-sm text-nowrap">
            <tbody>
              <tr>
                <th style="width:200px;" class="bg-danger">Nama Lengkap</th>
                <td>{{ $kontrak->mitra->nama_lengkap }}</td>
              </tr>
              <tr>
                <th class="bg-danger">NMS</th>
                <td>{{ $kontrak->mitra->nms }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Jenis Kelamin</th>
                <td>{{ $kontrak->mitra->jenis_kelamin ?? '-' }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Alamat</th>
                <td>{{ $kontrak->mitra->alamat ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Data Kontrak -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="card-title">Data Kontrak</h5>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-sm text-nowrap">
            <tbody>
              <tr>
                <th class="bg-primary text-uppercase" style="width:200px;">Periode Kontrak</th>
                <td class="bg-primary font-weight-bold text-uppercase">{{ $kontrak->periode->translatedFormat('F Y') }}
                </td>
              </tr>
              <tr>
                <th style="width:200px;" class="bg-danger">Tanggal Kontrak</th>
                <td>{{ $kontrak->tanggal_kontrak->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Tanggal Surat</th>
                <td>{{ $kontrak->tanggal_surat->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Tanggal BAST</th>
                <td>{{ $kontrak->tanggal_bast->translatedFormat('d F Y') }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Jadwal</th>
                <td>
                  {{ $kontrak->tanggal_mulai->translatedFormat('d F Y') }} -
                  {{ $kontrak->tanggal_berakhir->translatedFormat('d F Y') }}
                </td>
              </tr>
              <tr>
                <th class="bg-danger">Keterangan</th>
                <td>{{ $kontrak->keterangan ?? '-' }}</td>
              </tr>
              <tr>
                <th class="bg-danger">Total Honor</th>
                <td>Rp {{ number_format($kontrak->total_honor, 0, ',', '.') }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>

    <!-- Data Tugas -->
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="card-title">Daftar Tugas</h5>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap text-sm">
            <thead class="bg-danger text-sm">
              <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Anggaran</th>
                <th>Deskripsi Tugas</th>
                <th>Jlh. Target Dokumen</th>
                <th>Jlh. Dokumen</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($kontrak->tugas as $index => $tugas)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $tugas->anggaran->kode_anggaran ?? '-' }}</td>
                  <td>{{ $tugas->anggaran->nama_kegiatan ?? '-' }}</td>
                  <td>{{ $tugas->deskripsi_tugas }}</td>
                  <td>{{ $tugas->jumlah_target_dokumen }}</td>
                  <td>{{ $tugas->jumlah_dokumen }}</td>
                  <td>{{ $tugas->satuan }}</td>
                  <td>Rp {{ number_format($tugas->harga_satuan, 0, ',', '.') }}</td>
                  <td>Rp {{ number_format($tugas->harga_total_tugas, 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center">Belum ada tugas</td>
                </tr>
              @endforelse
            </tbody>
            @if ($kontrak->tugas->count())
              <tfoot>
                <tr>
                  <th colspan="8" class="text-right">Total Honor</th>
                  <th>Rp {{ number_format($kontrak->total_honor, 0, ',', '.') }}</th>
                </tr>
                <tr>
                  <th colspan="8" class="text-right">Realisasi</th>
                  <th>
                    {{ number_format(($kontrak->tugas->sum('jumlah_dokumen') / $kontrak->tugas->sum('jumlah_target_dokumen')) * 100, 1) }}%
                  </th>
                </tr>
              </tfoot>
            @endif
          </table>
        </div>

        <div class="card-footer">
          <a href="{{ route('kontrak.index') }}" class="btn btn-sm btn-secondary">Kembali</a>

          @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
            <a href="{{ route('kontrak.edit', $kontrak->id) }}" class="btn btn-sm btn-primary">Edit</a>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
