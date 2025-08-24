@extends('layouts.template')

@push('css-libs')
  <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #f9fafb;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      height: 2.5rem !important;
      padding-right: 2.5rem;
      display: flex;
      align-items: center;
      font-size: 1rem;
      color: #111827;
    }

    .select2-selection__rendered {
      color: #111827;
      font-size: 1rem;
      line-height: 1rem;
    }

    .select2-selection__arrow {
      height: 100% !important;
      top: 0 !important;
      right: 0.75rem !important;
      width: 2rem !important;
      color: #6b7280;
    }

    .select2-dropdown {
      background-color: white;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      font-size: 1rem;
      z-index: 9999;
    }
  </style>
@endpush

@section('content')
  <div class="col-md-12">

    <x-alert />


    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('kontrak.update', $kontrak->id) }}">
          @csrf
          @method('PUT')

          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="mitra_id">Mitra</label>
                <select name="mitra_id" id="mitra_id" class="custom-select select2">
                  <option value="" disabled>-- Pilih Mitra --</option>
                  @foreach ($mitra as $m)
                    <option value="{{ $m->id }}"
                      {{ old('mitra_id', $kontrak->mitra_id) == $m->id ? 'selected' : '' }}>
                      {{ $m->nama_lengkap }} - {{ $m->nms }}
                    </option>
                  @endforeach
                </select>
                @error('mitra_id')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_kontrak">Tanggal kontrak</label>
                <input type="date" class="form-control" id="tanggal_kontrak" name="tanggal_kontrak"
                  value="{{ old('tanggal_kontrak', $kontrak->tanggal_kontrak) }}" onclick="this.showPicker()">
                @error('tanggal_kontrak')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_surat">Tanggal surat</label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat"
                  value="{{ old('tanggal_surat', $kontrak->tanggal_surat) }}" onclick="this.showPicker()">
                @error('tanggal_surat')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_bast">Tanggal BAST</label>
                <input type="date" class="form-control" id="tanggal_bast" name="tanggal_bast"
                  value="{{ old('tanggal_bast', $kontrak->tanggal_bast) }}" onclick="this.showPicker()">
                @error('tanggal_bast')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>

            <!-- Kanan -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" rows="12" name="keterangan"
                  placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $kontrak->keterangan) }}</textarea>
                @error('keterangan')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
          </div>

          <hr>

          <!-- Table tugas -->
          <h5>Tugas / Kegiatan</h5>
          <table class="table table-bordered table-sm text-sm" id="tugas-table">
            <thead>
              <tr>
                <th>Anggaran</th>
                <th>Deskripsi Tugas</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kontrak->tugas as $i => $tugas)
                <tr>
                  <td>
                    <select name="tugas[{{ $i }}][anggaran_id]" class="form-control select2">
                      <option value="">-- Pilih Anggaran --</option>
                      @foreach ($anggaran as $a)
                        <option value="{{ $a->id }}"
                          {{ old("tugas.$i.anggaran_id", $tugas->anggaran_id) == $a->id ? 'selected' : '' }}>
                          {{ $a->kode_anggaran }} - {{ $a->uraian }}
                        </option>
                      @endforeach
                    </select>
                    @error("tugas.$i.anggaran_id")
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </td>
                  <td>
                    <input type="text" name="tugas[{{ $i }}][deskripsi_tugas]" class="form-control"
                      value="{{ old("tugas.$i.deskripsi_tugas", $tugas->deskripsi_tugas) }}">
                    @error("tugas.$i.deskripsi_tugas")
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </td>
                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_dokumen]" class="form-control"
                      value="{{ old("tugas.$i.jumlah_dokumen", $tugas->jumlah_dokumen) }}">
                    @error("tugas.$i.jumlah_dokumen")
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </td>
                  <td>
                    <input type="text" name="tugas[{{ $i }}][satuan]" class="form-control"
                      value="{{ old("tugas.$i.satuan", $tugas->satuan) }}">
                    @error("tugas.$i.satuan")
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </td>
                  <td>
                    <input type="number" step="0.01" name="tugas[{{ $i }}][harga_satuan]"
                      class="form-control" value="{{ old("tugas.$i.harga_satuan", $tugas->harga_satuan) }}">
                    @error("tugas.$i.harga_satuan")
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm btn-remove">Hapus</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <button type="button" class="btn btn-success btn-sm" id="addRow">Tambah Tugas</button>

          <hr>
          <a href="{{ route('kontrak.index') }}" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('select2/select2.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        width: '100%'
      });

      // tambah baris baru
      let rowIndex = {{ $kontrak->tugas->count() }};
      $('#addRow').click(function() {
        let row = `
          <tr>
            <td>
              <select name="tugas[${rowIndex}][anggaran_id]" class="form-control select2">
                <option value="">-- Pilih Anggaran --</option>
                @foreach ($anggaran as $a)
                  <option value="{{ $a->id }}">{{ $a->kode_anggaran }} - {{ $a->uraian }}</option>
                @endforeach
              </select>
            </td>
            <td><input type="text" name="tugas[${rowIndex}][deskripsi_tugas]" class="form-control"></td>
            <td><input type="number" name="tugas[${rowIndex}][jumlah_dokumen]" class="form-control"></td>
            <td>
              <input type="text" name="tugas[${rowIndex}][satuan]" class="form-control">
            </td>
            <td><input type="number" step="0.01" name="tugas[${rowIndex}][harga_satuan]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm btn-remove">Hapus</button></td>
          </tr>`;
        $('#tugas-table tbody').append(row);
        $('.select2').select2({
          width: '100%'
        });
        rowIndex++;
      });

      // hapus baris
      $(document).on('click', '.btn-remove', function() {
        $(this).closest('tr').remove();
      });
    });
  </script>
@endsection
