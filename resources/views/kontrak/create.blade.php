@extends('layouts.template')

@push('css-libs')
  <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #f9fafb;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      height: 2.5rem !important;
      display: flex;
      align-items: center;
      font-size: 1rem;
      color: #111827;
    }

    .select2-selection__rendered {
      color: #111827;
      font-size: 1rem;
    }

    .select2-selection__arrow {
      height: 100% !important;
      top: 0 !important;
      right: 0.75rem !important;
    }

    .select2-dropdown {
      border-radius: 0.5rem;
      font-size: 1rem;
    }
  </style>
@endpush

@section('content')
  <div class="col-md-12">

    <x-alert />

    <div class="card card-primary">
      <div class="card-body">
        <h5> Input Kontrak</h5>

        <form method="POST" action="{{ route('kontrak.store') }}">
          @csrf
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="mitra_id">Mitra</label>
                <select name="mitra_id" id="mitra_id" class="custom-select select2">
                  <option value="" disabled {{ old('mitra_id') ? '' : 'selected' }}>-- Pilih Mitra --</option>
                  @foreach ($mitra as $m)
                    <option value="{{ $m->id }}" {{ old('mitra_id') == $m->id ? 'selected' : '' }}>
                      {{ $m->nama_lengkap }} - {{ $m->nms }}
                    </option>
                  @endforeach
                </select>
                @error('mitra_id')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_kontrak">Tanggal Kontrak</label>
                <input type="date" class="form-control @error('tanggal_kontrak') is-invalid @enderror"
                  id="tanggal_kontrak" name="tanggal_kontrak" value="{{ old('tanggal_kontrak') }}"
                  onclick="this.showPicker()" />
                @error('tanggal_kontrak')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_surat">Tanggal Surat</label>
                <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat"
                  name="tanggal_surat" value="{{ old('tanggal_surat') }}" onclick="this.showPicker()" />
                @error('tanggal_surat')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_bast">Tanggal BAST</label>
                <input type="date" class="form-control @error('tanggal_bast') is-invalid @enderror" id="tanggal_bast"
                  name="tanggal_bast" value="{{ old('tanggal_bast') }}" onclick="this.showPicker()" />
                @error('tanggal_bast')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>

            <!-- Kanan -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" rows="12"
                  placeholder="Masukkan keterangan (opsional)" name="keterangan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>
          </div>

          <hr>
          <!-- Tugas -->
          <h5> Input Tugas</h5>
          <table class="table table-bordered table-sm text-sm" id="tugas-table">
            <thead>
              <tr>
                <th>Anggaran</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="tugas-row">
                <td>
                  <select name="tugas[0][anggaran_id]" class="form-control select2">
                    @foreach ($anggaran as $a)
                      <option value="{{ $a->id }}">{{ $a->nama_kegiatan }}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <input type="text" name="tugas[0][deskripsi_tugas]"
                    class="form-control @error('tugas.0.deskripsi_tugas') is-invalid @enderror">
                  @error('tugas.0.deskripsi_tugas')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </td>

                <td>
                  <input type="number" name="tugas[0][jumlah_dokumen]"
                    class="form-control @error('tugas.0.jumlah_dokumen') is-invalid @enderror">
                  @error('tugas.0.jumlah_dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </td>

                <td>
                  <input type="text" name="tugas[0][satuan]"
                    class="form-control @error('tugas.0.satuan') is-invalid @enderror">
                  @error('tugas.0.satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </td>

                <td>
                  <input type="text" step="0.01" name="tugas[0][harga_satuan]" inputmode="numeric"
                    class="form-control rupiah-input @error('tugas.0.harga_satuan') is-invalid @enderror">
                  @error('tugas.0.harga_satuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </td>

                <td><button type="button" class="btn btn-danger btn-remove btn-sm">Hapus</button></td>
              </tr>
            </tbody>
          </table>
          <button type="button" id="add-row" class="btn btn-success mb-3 btn-sm">Tambah Tugas</button>

          <br>
          <a href="{{ route('kontrak.index') }}" class="btn btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
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

      let rowIndex = 1;
      $('#add-row').click(function() {
        let newRow = `
        <tr class="tugas-row">
          <td>
            <select name="tugas[${rowIndex}][anggaran_id]" class="form-control">
              @foreach ($anggaran as $a)
                <option value="{{ $a->id }}">{{ $a->nama_kegiatan }}</option>
              @endforeach
            </select>
          </td>
          <td><input type="text" name="tugas[${rowIndex}][deskripsi_tugas]" class="form-control"></td>
          <td><input type="number" name="tugas[${rowIndex}][jumlah_dokumen]" class="form-control"></td>
          <td><input type="text" name="tugas[${rowIndex}][satuan]" class="form-control"></td>
          <td><input type="text" name="tugas[${rowIndex}][harga_satuan]" class="form-control rupiah-input"></td>
          <td><button type="button" class="btn btn-danger btn-remove">Hapus</button></td>
        </tr>
      `;
        $('#tugas-table tbody').append(newRow);
        rowIndex++;
      });

      // Hapus row
      $(document).on('click', '.btn-remove', function() {
        $(this).closest('tr').remove();
      });

      // 🔥 Event delegation: format ke Rupiah setiap keyup di semua .rupiah-input (lama & baru)
      $(document).on('keyup', '.rupiah-input', function() {
        let value = $(this).val().replace(/[^,\d]/g, '');
        $(this).val(value ? formatRupiah(value) : '');
      });

      // 🔥 Hapus format sebelum submit form
      $('form').on('submit', function() {
        $('.rupiah-input').each(function() {
          $(this).val($(this).val().replace(/\D/g, '')); // hanya angka
        });
      });

      // Fungsi format rupiah
      function formatRupiah(angka) {
        let number_string = angka.toString(),
          sisa = number_string.length % 3,
          rupiah = number_string.substr(0, sisa),
          ribuan = number_string.substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
        return 'Rp ' + rupiah;
      }
    });
  </script>
@endsection
