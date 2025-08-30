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
        <h5 class="text-primary">Kontrak</h5>

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
          <h5 class="text-primary">Tugas / Kegiatan</h5>
          <table class="table table-bordered text-sm table-responsive" id="tugas-table">
            <thead>
              <tr>
                <th>Anggaran</th>
                <th>Deskripsi</th>
                <th>Jumlah Target</th>
                <th>Jumlah dicapai</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php
                $oldTugas = old('tugas', [[]]);
              @endphp
              @foreach ($oldTugas as $i => $tugas)
                <tr>
                  <td>
                    <select name="tugas[{{ $i }}][anggaran_id]"
                      class="custom-select select2 @error('tugas.' . $i . '.anggaran_id') is-invalid @enderror">
                      <option value="" {{ isset($tugas['anggaran_id']) ? '' : 'selected' }}>-- Pilih Anggaran --
                      </option>
                      @foreach ($anggaran as $a)
                        <option value="{{ $a->id }}"
                          {{ isset($tugas['anggaran_id']) && $tugas['anggaran_id'] == $a->id ? 'selected' : '' }}>
                          {{ $a->nama_kegiatan }}
                        </option>
                      @endforeach
                    </select>
                    @error('tugas.' . $i . '.anggaran_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <input type="text" name="tugas[{{ $i }}][deskripsi_tugas]" autocomplete="off"
                      class="form-control @error('tugas.' . $i . '.deskripsi_tugas') is-invalid @enderror"
                      value="{{ $tugas['deskripsi_tugas'] ?? '' }}">
                    @error('tugas.' . $i . '.deskripsi_tugas')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_target_dokumen]" autocomplete="off"
                      class="form-control @error('tugas.' . $i . '.jumlah_target_dokumen') is-invalid @enderror"
                      value="{{ $tugas['jumlah_target_dokumen'] ?? '' }}">
                    @error('tugas.' . $i . '.jumlah_target_dokumen')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_dokumen]" autocomplete="off"
                      class="form-control @error('tugas.' . $i . '.jumlah_dokumen') is-invalid @enderror"
                      value="{{ $tugas['jumlah_dokumen'] ?? '' }}">
                    @error('tugas.' . $i . '.jumlah_dokumen')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="text" name="tugas[{{ $i }}][satuan]" autocomplete="off"
                      class="form-control @error('tugas.' . $i . '.satuan') is-invalid @enderror"
                      value="{{ $tugas['satuan'] ?? '' }}">
                    @error('tugas.' . $i . '.satuan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <input type="text" name="tugas[{{ $i }}][harga_satuan_display]" autocomplete="off"
                      class="form-control currency-input @error('tugas.' . $i . '.harga_satuan') is-invalid @enderror"
                      value="{{ isset($tugas['harga_satuan']) ? number_format($tugas['harga_satuan'], 0, ',', '.') : '' }}">


                    <input type="hidden" name="tugas[{{ $i }}][harga_satuan]" class="harga-satuan-hidden"
                      value="{{ $tugas['harga_satuan'] ?? '' }}">

                    @error('tugas.' . $i . '.harga_satuan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <button type="button" class="btn btn-danger btn-remove btn-sm">Hapus</button>
                  </td>
                </tr>
              @endforeach
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
    <tr>
      <td>
        <select name="tugas[${rowIndex}][anggaran_id]" class="custom-select select2">
          <option value="" disabled selected>-- Pilih Anggaran --</option>
          @foreach ($anggaran as $a)
            <option value="{{ $a->id }}"
              {{ old('tugas.' . '${rowIndex}' . '.anggaran_id') == $a->id ? 'selected' : '' }}>
              {{ $a->nama_kegiatan }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="text" name="tugas[${rowIndex}][deskripsi_tugas]" class="form-control" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.deskripsi_tugas') }}">
      </td>
      <td>
        <input type="number" name="tugas[${rowIndex}][jumlah_target_dokumen]" class="form-control" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.jumlah_target_dokumen') }}">
      </td>
      <td>
        <input type="number" name="tugas[${rowIndex}][jumlah_dokumen]" class="form-control" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.jumlah_dokumen') }}">
      </td>
      <td>
        <input type="text" name="tugas[${rowIndex}][satuan]" class="form-control" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.satuan') }}">
      </td>
      <td>
        <input type="text" name="tugas[${rowIndex}][harga_satuan_display]"  automplete="off" 
               class="form-control currency-input"
               value="{{ old('tugas.' . '${rowIndex}' . '.harga_satuan') ? number_format(old('tugas.' . '${rowIndex}' . '.harga_satuan'), 0, ',', '.') : '' }}">
        <input type="hidden" name="tugas[${rowIndex}][harga_satuan]" 
               class="harga-satuan-hidden"
               value="{{ old('tugas.' . '${rowIndex}' . '.harga_satuan') }}">
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-remove btn-sm">Hapus</button>
      </td>
    </tr>
  `;

        $('#tugas-table tbody').append(newRow);

        // init select2
        $('.select2').select2({
          width: '100%'
        });

        rowIndex++;
      });

      // format ribuan
      function formatRibuan(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      function cleanNumber(str) {
        return str.replace(/\./g, '');
      }

      // event format untuk semua currency-input (lama + baru)
      $(document).on("input", ".currency-input", function() {
        let raw = cleanNumber($(this).val());
        if (raw === "") {
          $(this).val("");
          $(this).siblings(".harga-satuan-hidden").val("");
          return;
        }

        let formatted = formatRibuan(raw);
        $(this).val(formatted);

        // update hidden input dengan angka asli
        $(this).siblings(".harga-satuan-hidden").val(raw);
      });

      // hapus row
      $(document).on('click', '.btn-remove', function() {
        $(this).closest('tr').remove();
      });
    });
  </script>
@endsection
