@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('mitra.store') }}">
          @csrf
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nms" class="text-sm">NMS</label>
                <input type="text"
                  class="form-control form-control-sm @error('nms')
									is-invalid
								@enderror" id="nms"
                  name="nms" placeholder="Masukkan NMS" value="{{ old('nms') }}" autocomplete="off">
                @error('nms')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_lengkap" class="text-sm">Nama Lengkap</label>
                <input type="text"
                  class="form-control form-control-sm @error('nama_lengkap')
									is-invalid
								@enderror"
                  name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan nama lengkap" autocomplete="off"
                  value="{{ old('nama_lengkap') }}">
                @error('nama_lengkap')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group" class="text-sm">
                <label for="jenis_kelamin" class="text-sm">Jenis Kelamin</label>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_l"
                      value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                    <label class="form-check-label text-sm" for="jenis_kelamin_l">
                      Laki-laki
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_p"
                      value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label text-sm" for="jenis_kelamin_p">Perempuan</label>
                  </div>
                  @error('jenis_kelamin')
                    <x-input-validation>{{ $message }}</x-input-validation>
                  @enderror
                </div>
              </div>
            </div>

            <!-- Kanan -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="alamat" class="text-sm">Alamat</label>
                <textarea class="form-control form-control-sm @error('alamat')
									is-invalid
								@enderror" id="alamat"
                  rows="8" placeholder="Masukkan alamat" name="alamat">{{ old('alamat') }}</textarea>
                @error('alamat')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>
            </div>
          </div>

          <a href="{{ route('mitra.index') }}">
            <button type="button" class="btn btn-sm btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
@endsection
