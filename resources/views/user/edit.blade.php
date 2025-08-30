@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('user.update', $user->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap')
									is-invalid
								@enderror"
                  id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama lengkap"
                  value="{{ old('nama_lengkap', $user->nama_lengkap) }}" autocomplete="off">
                @error('nama_lengkap')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="nip">NIP</label>
                <input type="nip" class="form-control @error('nip')
									is-invalid
								@enderror"
                  id="nip" name="nip" placeholder="Masukkan NIP" value="{{ old('nip', $user->nip) }}"
                  autocomplete="off">
                @error('nip')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email')
									is-invalid
								@enderror"
                  id="email" name="email" placeholder="Masukkan email" value="{{ old('email', $user->email) }}"
                  autocomplete="off">
                @error('email')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="jabatan" class="form-control @error('jabatan')
									is-invalid
								@enderror"
                  id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                  autocomplete="off">
                @error('jabatan')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>
            </div>

          </div>

          <a href="{{ route('user.index') }}">
            <button type="button" class="btn btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
@endsection
