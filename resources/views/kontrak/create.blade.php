@extends('layouts.template')

@push('css-libs')
  <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #f9fafb;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      height: 2rem !important;
      padding-right: 1.5rem;
      display: flex;
      align-items: center;
      font-size: 14px;
      color: #111827;
    }

    .select2-selection__rendered {
      color: #111827;
      font-size: 14px;
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
      font-size: 14px;
      z-index: 9999;
    }

    .col-anggaran {
      width: 15%;
    }

    .col-deskripsi {
      width: 35%;
    }

    .col-target {
      width: 12%;
      text-align: right;
    }

    .col-dicapai {
      width: 12%;
      text-align: right;
    }

    .col-satuan {
      width: 12%;
    }

    .col-harga {
      width: 17%;
      text-align: right;
    }

    .col-aksi {
      width: 5%;
      text-align: center;
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
                <select name="mitra_id" id="mitra_id" class="select2">
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

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="tanggal_kontrak">Tanggal Kontrak</label>
                    <input type="date" class="form-control @error('tanggal_kontrak') is-invalid @enderror"
                      id="tanggal_kontrak" name="tanggal_kontrak" value="{{ old('tanggal_kontrak') }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_kontrak')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="tanggal_surat">Tanggal Surat</label>
                    <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                      id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_surat')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="tanggal_bast">Tanggal BAST</label>
                    <input type="date" class="form-control @error('tanggal_bast') is-invalid @enderror"
                      id="tanggal_bast" name="tanggal_bast" value="{{ old('tanggal_bast') }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_bast')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="tanggal_bast">Periode Kontrak</label>
                    <input type="month" class="form-control @error('periode') is-invalid @enderror" id="periode"
                      name="periode" value="{{ old('periode') }}" onclick="this.showPicker()" />
                    @error('periode')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

            <!-- Kanan -->
            <div class="col-sm-6">

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="tanggal_mulai">Jadwal (Tgl. Mulai)</label>
                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                      id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_mulai')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>

                  <div class="col-sm-6">
                    <label for="tanggal_berakhir">Jadwal (Tgl. Berakhir)</label>
                    <input type="date" class="form-control @error('tanggal_berakhir') is-invalid @enderror"
                      id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_berakhir')
                      <small class="text-danger">{{ ucfirst($message) }}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" rows="2"
                  placeholder="Masukkan keterangan (opsional)" name="keterangan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                  <small class="text-danger">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>

          </div>

          <hr>

          <div class="">
            <a class="btn btn-info btn-sm mb-2" data-toggle="collapse" href="#collapseExample" role="button"
              aria-expanded="false" aria-controls="collapseExample">
              Lihat Anggaran
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-chevron-down-icon lucide-chevron-down">
                <path d="m6 9 6 6 6-6" />
              </svg>
            </a>

            <div class="collapse" id="collapseExample">
              <div class="table-responsive p-0">
                <table class="table table-sm text-sm table-bordered text-nowrap">
                  <thead class="bg-info">
                    <tr>
                      <th scope="col">Kode Akun</th>
                      <th scope="col">Anggaran</th>
                      <th scope="col">Sisa</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($anggaran as $item)
                      <tr>
                        <td>{{ $item->kode_anggaran }}</td>
                        <td>{{ $item->nama_kegiatan }}</td>
                        <td>Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}</td>
                    @endforeach
                  </tbody>
                  </tr>
                </table>
              </div>
            </div>
          </div>


          <!-- Tugas -->
          <h5 class="text-primary">Tugas / Kegiatan</h5>
          <table class="table table-bordered table-responsive" id="tugas-table">
            <thead class="text-sm bg-info">
              <tr>
                <th class="col-anggaran">Anggaran</th>
                <th class="col-deskripsi">Deskripsi tugas</th>
                <th class="col-target">Jumlah Target</th>
                <th class="col-dicapai">Jumlah Dicapai</th>
                <th class="col-satuan">Satuan</th>
                <th class="col-harga">Harga Satuan</th>
                <th class="col-aksi">Aksi</th>
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
                          {{ $a->kode_anggaran }}

                        </option>
                      @endforeach
                    </select>
                    @error('tugas.' . $i . '.anggaran_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <textarea name="tugas[{{ $i }}][deskripsi_tugas]"
                      class="form-control form-control-sm @error('tugas.' . $i . '.deskripsi_tugas') is-invalid @enderror" rows="3"
                      autocomplete="off">{{ $tugas['deskripsi_tugas'] ?? '' }}</textarea>
                    @error('tugas.' . $i . '.deskripsi_tugas')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_target_dokumen]" autocomplete="off"
                      class="form-control form-control-sm @error('tugas.' . $i . '.jumlah_target_dokumen') is-invalid @enderror"
                      value="{{ $tugas['jumlah_target_dokumen'] ?? '' }}">
                    @error('tugas.' . $i . '.jumlah_target_dokumen')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_dokumen]" autocomplete="off"
                      class="form-control form-control-sm @error('tugas.' . $i . '.jumlah_dokumen') is-invalid @enderror"
                      value="{{ $tugas['jumlah_dokumen'] ?? '' }}">
                    @error('tugas.' . $i . '.jumlah_dokumen')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>
                  <td>
                    <input type="text" name="tugas[{{ $i }}][satuan]" autocomplete="off"
                      class="form-control form-control-sm @error('tugas.' . $i . '.satuan') is-invalid @enderror"
                      value="{{ $tugas['satuan'] ?? '' }}">
                    @error('tugas.' . $i . '.satuan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <input type="text" name="tugas[{{ $i }}][harga_satuan_display]" autocomplete="off"
                      class="form-control form-control-sm currency-input @error('tugas.' . $i . '.harga_satuan') is-invalid @enderror"
                      value="{{ isset($tugas['harga_satuan']) ? number_format($tugas['harga_satuan'], 0, ',', '.') : '' }}">

                    <input type="hidden" name="tugas[{{ $i }}][harga_satuan]" class="harga-satuan-hidden"
                      autocomplete="off" value="{{ $tugas['harga_satuan'] ?? '' }}">

                    @error('tugas.' . $i . '.harga_satuan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </td>

                  <td>
                    <button type="button" class="btn btn-danger btn-remove btn-sm">&times;</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <button type="button" id="add-row" class="btn btn-success mb-3 btn-sm">&plus;</button>

          <br />

          <a href="{{ route('kontrak.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
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
              {{ $a->kode_anggaran }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <textarea type="text" name="tugas[${rowIndex}][deskripsi_tugas]" class="form-control form-control-sm" autocomplete="off"
          rows="3">{{ old('tugas.' . '${rowIndex}' . '.deskripsi_tugas') }}</textarea>
      </td>
      <td>
        <input type="number" name="tugas[${rowIndex}][jumlah_target_dokumen]" class="form-control form-control-sm" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.jumlah_target_dokumen') }}">
      </td>
      <td>
        <input type="number" name="tugas[${rowIndex}][jumlah_dokumen]" class="form-control form-control-sm" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.jumlah_dokumen') }}">
      </td>
      <td>
        <input type="text" name="tugas[${rowIndex}][satuan]" class="form-control form-control-sm" autocomplete="off"
          value="{{ old('tugas.' . '${rowIndex}' . '.satuan') }}">
      </td>
      <td>
        <input type="text" name="tugas[${rowIndex}][harga_satuan_display]"  automplete="off" 
               class="form-control form-control-sm currency-input"
               value="{{ old('tugas.' . '${rowIndex}' . '.harga_satuan') ? number_format(old('tugas.' . '${rowIndex}' . '.harga_satuan'), 0, ',', '.') : '' }}">
        <input type="hidden" name="tugas[${rowIndex}][harga_satuan]" autocomplete="off"
               class="harga-satuan-hidden"
               value="{{ old('tugas.' . '${rowIndex}' . '.harga_satuan') }}">
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-remove btn-sm">&times;</button>
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
