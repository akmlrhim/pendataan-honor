@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-body">
        <form method="POST" action="{{ route('tambahan.update', $sett->uuid) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="value" class="text-sm">Value
                  <span class="text-xs text-danger">
                    (Perhatikan baik-baik jika value yang dimasukkan adalah nominal uang!.)
                  </span>
                </label>
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm @error('value') is-invalid @enderror"
                    id="value" placeholder="Masukkan value" name="value" value="{{ old('value', $sett->value) }}"
                    autocomplete="off" />
                </div>
                @error('value')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

            </div>
          </div>

          <a href="{{ route('tambahan.index') }}">
            <button type="button" class="btn btn-sm btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
@endsection
