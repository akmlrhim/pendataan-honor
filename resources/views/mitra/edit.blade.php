@extends('layouts.template')

@section('content')
  <div class="col-md-12">

    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('mitra.update', $mitra->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nms">NMS</label>
                <input type="text" class="form-control @error('nms')
									is-invalid
								@enderror"
                  id="nms" name="nms" placeholder="Masukkan NMS" value="{{ old('nms', $mitra->nms) }}"
                  autocomplete="off">
                @error('nms')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap')
									is-invalid
								@enderror"
                  name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan nama lengkap" autocomplete="off"
                  value="{{ old('nama_lengkap', $mitra->nama_lengkap) }}">
                @error('nama_lengkap')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_l"
                      value="Laki-laki" {{ old('jenis_kelamin', $mitra->jenis_kelamin) == 'Laki-Laki' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_p"
                      value="Perempuan" {{ old('jenis_kelamin', $mitra->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                    <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                  </div>

                  @error('jenis_kelamin')
                    <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                  @enderror
                </div>
              </div>

            </div>

            <!-- Kanan -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat')
									is-invalid
								@enderror" id="alamat" rows="8"
                  placeholder="Masukkan alamat" name="alamat">{{ old('alamat', $mitra->alamat) }}</textarea>
                @error('alamat')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>
          </div>

          <a href="{{ route('mitra.index') }}">
            <button type="button" class="btn btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
@endsection
