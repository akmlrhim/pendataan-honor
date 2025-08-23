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

    .select2-results__option {
      padding: 0.5rem 0.75rem;
      cursor: pointer;
    }

    .select2-results__option--selected {
      background-color: #dbeafe;
      color: #1e40af;
      font-weight: 600;
    }

    .select2-results__option--highlighted {
      background-color: #bfdbfe;
    }

    .select2-search--dropdown .select2-search__field {
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      padding: 0.5rem 0.75rem;
      width: 100%;
    }
  </style>
@endpush

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
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
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>


              <div class="form-group">
                <label for="tanggal_kontrak">Tanggal kontrak</label>
                <input type="date"
                  class="form-control 
                        @error('tanggal_kontrak')
                          is-invalid
                        @enderror"
                  id="tanggal_kontrak" name="tanggal_kontrak"
                  value="{{ old('tanggal_kontrak', isset($anggaran) ? $anggaran->tanggal_kontrak : '') }}"
                  onclick="this.showPicker()" />
                @error('tanggal_kontrak')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_surat">Tanggal surat</label>
                <input type="date"
                  class="form-control 
                        @error('tanggal_surat')
                          is-invalid
                        @enderror"
                  id="tanggal_surat" name="tanggal_surat"
                  value="{{ old('tanggal_surat', isset($anggaran) ? $anggaran->tanggal_surat : '') }}"
                  onclick="this.showPicker()" />
                @error('tanggal_surat')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="tanggal_bast">Tanggal BAST</label>
                <input type="date"
                  class="form-control 
                        @error('tanggal_bast')
                          is-invalid
                        @enderror"
                  id="tanggal_bast" name="tanggal_bast"
                  value="{{ old('tanggal_bast', isset($anggaran) ? $anggaran->tanggal_bast : '') }}"
                  onclick="this.showPicker()" />
                @error('tanggal_bast')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan')
									is-invalid
								@enderror" id="keterangan" rows="12"
                  placeholder="Masukkan keterangan (opsional)" name="keterangan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>
          </div>

          <a href="{{ route('kontrak.index') }}">
            <button type="button" class="btn btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>

    </div>

  @section('scripts')
    <script src="{{ asset('select2/select2.js') }}"></script>

    <script>
      $(document).ready(function() {
        $('.select2').select2({
          width: '100%'
        });
      });
    </script>
  @endsection
@endsection
