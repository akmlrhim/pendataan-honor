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


    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('kontrak.update', $kontrak->id) }}" id="form">
          @csrf
          @method('PUT')

          <h5 class="text-primary">Kontrak</h5>

          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="mitra_id" class="text-sm">Mitra</label>
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
                <div class="row">
                  <div class="col-sm-6">
                    <label for="tanggal_kontrak" class="text-sm">Tanggal kontrak</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_kontrak" name="tanggal_kontrak"
                      value="{{ old('tanggal_kontrak', $kontrak->tanggal_kontrak->format('Y-m-d')) }}"
                      onclick="this.showPicker()">
                    @error('tanggal_kontrak')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="col-sm-6">
                    <label for="tanggal_surat" class="text-sm">Tanggal surat</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_surat" name="tanggal_surat"
                      value="{{ old('tanggal_surat', $kontrak->tanggal_surat->format('Y-m-d')) }}"
                      onclick="this.showPicker()">
                    @error('tanggal_surat')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="tanggal_bast" class="text-sm">Tanggal BAST</label>
                    <input type="date" class="form-control form-control-sm" id="tanggal_bast" name="tanggal_bast"
                      value="{{ old('tanggal_bast', $kontrak->tanggal_bast->format('Y-m-d')) }}"
                      onclick="this.showPicker()">
                    @error('tanggal_bast')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="col-sm-6">
                    <label for="periode" class="text-sm">Periode Kontrak</label>
                    <input type="month" class="form-control form-control-sm" id="periode" name="periode"
                      value="{{ old('periode', $kontrak->periode ? \Carbon\Carbon::parse($kontrak->periode)->format('Y-m') : '') }}"
                      onclick="this.showPicker()">
                    @error('periode')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                </div>

              </div>
            </div>

            {{-- <!-- Kanan --> --}}
            <div class="col-sm-6">

              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label for="tanggal_mulai" class="text-sm">Jadwal (Tgl. Mulai)</label>
                    <input type="date"
                      class="form-control form-control-sm @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai"
                      name="tanggal_mulai" value="{{ old('tanggal_mulai', $kontrak->tanggal_mulai->format('Y-m-d')) }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_mulai')
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </div>

                  <div class="col-sm-6">
                    <label for="tanggal_berakhir" class="text-sm">Jadwal (Tgl. Berakhir)</label>
                    <input type="date"
                      class="form-control form-control-sm @error('tanggal_berakhir') is-invalid @enderror"
                      id="tanggal_berakhir" name="tanggal_berakhir"
                      value="{{ old('tanggal_berakhir', $kontrak->tanggal_berakhir->format('Y-m-d')) }}"
                      onclick="this.showPicker()" />
                    @error('tanggal_berakhir')
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="keterangan" class="text-sm">Keterangan</label>
                <textarea class="form-control form-control-sm @error('keterangan') is-invalid @enderror" id="keterangan" rows="2"
                  placeholder="Masukkan keterangan (opsional)" name="keterangan">{{ old('keterangan', $kontrak->keterangan) }}</textarea>
                @error('keterangan')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>
            </div>
          </div>

          <hr>

          <div>
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
              <div class="table-responsive mb-4">
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

          {{-- <!-- Table tugas --> --}}
          <h5 class="text-primary">Tugas / Kegiatan</h5>
          <table class="table table-bordered table-responsive text-sm text-nowrap" id="tugas-table">
            <thead class="bg-info text-sm">
              <tr>
                <th class="col-anggaran">Anggaran</th>
                <th class="col-deskripsi">Deskripsi tugas</th>
                <th class="col-target">Jlh. Target</th>
                <th class="col-dicapai">Jlh. Dicapai</th>
                <th class="col-satuan">Satuan</th>
                <th class="col-harga">Harga Satuan</th>
                <th class="col-aksi">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php
                $oldTugas = old('tugas', $kontrak->tugas->toArray());
              @endphp

              @foreach ($oldTugas as $i => $tugas)
                <tr>
                  <td>
                    <select name="tugas[{{ $i }}][anggaran_id]"
                      class="custom-select select2 @error("tugas.$i.anggaran_id") is-invalid @enderror">
                      <option value="">-- Pilih Anggaran --</option>
                      @foreach ($anggaran as $a)
                        <option value="{{ $a->id }}"
                          {{ old("tugas.$i.anggaran_id", $tugas['anggaran_id'] ?? null) == $a->id ? 'selected' : '' }}>
                          {{ $a->kode_anggaran }}
                        </option>
                      @endforeach
                    </select>
                    @error("tugas.$i.anggaran_id")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </td>

                  <td>
                    <textarea type="text" name="tugas[{{ $i }}][deskripsi_tugas]" autocomplete="off"
                      class="form-control form-control-sm @error("tugas.$i.deskripsi_tugas") is-invalid @enderror">{{ old("tugas.$i.deskripsi_tugas", $tugas['deskripsi_tugas'] ?? '') }}</textarea>
                    @error("tugas.$i.deskripsi_tugas")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </td>

                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_target_dokumen]" autocomplete="off"
                      class="form-control form-control-sm @error("tugas.$i.jumlah_target_dokumen") is-invalid @enderror"
                      value="{{ old("tugas.$i.jumlah_target_dokumen", $tugas['jumlah_target_dokumen'] ?? '') }}">
                    @error("tugas.$i.jumlah_target_dokumen")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </td>

                  <td>
                    <input type="number" name="tugas[{{ $i }}][jumlah_dokumen]" autocomplete="off"
                      class="form-control form-control-sm @error("tugas.$i.jumlah_dokumen") is-invalid @enderror"
                      value="{{ old("tugas.$i.jumlah_dokumen", $tugas['jumlah_dokumen'] ?? '') }}">
                    @error("tugas.$i.jumlah_dokumen")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </td>

                  <td>
                    <input type="text" name="tugas[{{ $i }}][satuan]" autocomplete="off"
                      class="form-control form-control-sm @error("tugas.$i.satuan") is-invalid @enderror"
                      value="{{ old("tugas.$i.satuan", $tugas['satuan'] ?? '') }}">
                    @error("tugas.$i.satuan")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror
                  </td>

                  <td>
                    <!-- input tampilan -->
                    <input type="text"
                      class="form-control form-control-sm currency-input @error("tugas.$i.harga_satuan") is-invalid @enderror"
                      autocomplete="off"
                      value="{{ isset($tugas['harga_satuan']) ? number_format($tugas['harga_satuan'], 0, ',', '.') : '' }}">

                    <input type="hidden" name="tugas[{{ $i }}][harga_satuan]"
                      class="harga-satuan-hidden @error("tugas.$i.harga_satuan") is-invalid @enderror"
                      value="{{ $tugas['harga_satuan'] ?? '' }}">

                    @error("tugas.$i.harga_satuan")
                      <x-input-validation>{{ $message }}</x-input-validation>
                    @enderror

                  </td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm btn-remove">&times;</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <button type="button" class="btn btn-sm btn-success btn-sm" id="addRow">&plus;</button>

          <hr>
          <a href="{{ route('kontrak.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
          <button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
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
    });

    let rowIndex = {{ $kontrak->tugas->count() }};

    $('#addRow').click(function() {
      let row = `
      <tr>
        <td>
          <select name="tugas[${rowIndex}][anggaran_id]" class="custom-select select2">
            <option value="" disabled selected>-- Pilih Anggaran --</option>
            @foreach ($anggaran as $a)
              <option value="{{ $a->id }}">{{ $a->kode_anggaran }}</option>
            @endforeach
          </select>
        </td>
        <td>
          <textarea type="text" name="tugas[${rowIndex}][deskripsi_tugas]" class="form-control form-control-sm" autocomplete="off"></textarea>
        </td>
        <td>
          <input type="number" name="tugas[${rowIndex}][jumlah_target_dokumen]" class="form-control form-control-sm" autocomplete="off">
        </td>
        <td>
          <input type="number" name="tugas[${rowIndex}][jumlah_dokumen]" class="form-control form-control-sm" autocomplete="off">
        </td>
        <td>
          <input type="text" name="tugas[${rowIndex}][satuan]" class="form-control form-control-sm" autocomplete="off">
        </td>
        <td>
          <!-- input tampilan -->
          <input type="text" class="form-control form-control-sm currency-input" autocomplete="off">
          <!-- input hidden untuk validasi -->
          <input type="hidden" name="tugas[${rowIndex}][harga_satuan]" class="harga-satuan-hidden">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-remove btn-sm">&times;</button>
        </td>
      </tr>
    `;

      $('#tugas-table tbody').append(row);

      // re-init select2 biar jalan di row baru
      $('.select2').select2({
        width: '100%'
      });

      // aktifkan formatter untuk currency input baru
      document.querySelectorAll('.currency-input').forEach(setupCurrencyInput);

      rowIndex++;
    });

    // handle hapus row
    $(document).on('click', '.btn-remove', function() {
      $(this).closest('tr').remove();
    });

    // fungsi untuk sinkronisasi currency input ke hidden field
    function setupCurrencyInput(input) {
      input.addEventListener('input', function() {
        let raw = this.value.replace(/\D/g, ''); // angka mentah

        // update hidden input di td yang sama
        let hidden = this.closest('td').querySelector('.harga-satuan-hidden');
        if (hidden) hidden.value = raw;

        // tampilkan format ribuan di input user
        this.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
      });
    }

    // inisialisasi untuk semua input awal
    document.querySelectorAll('.currency-input').forEach(setupCurrencyInput);
  </script>
@endsection
