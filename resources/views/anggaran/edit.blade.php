@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('anggaran.update', $anggaran->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode_anggaran" class="text-sm">Kode akun anggaran</label>
                <input type="text"
                  class="form-control form-control-sm  @error('kode_anggaran')
									is-invalid
								@enderror"
                  id="kode_anggaran" name="kode_anggaran" placeholder="Masukkan kode anggaran" autocomplete="off"
                  value="{{ old('kode_anggaran', $anggaran->kode_anggaran) }}">
                @error('kode_anggaran')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_kegiatan" class="text-sm">Nama kegiatan</label>
                <input type="text"
                  class="form-control form-control-sm @error('nama_kegiatan')
									is-invalid
								@enderror"
                  id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" autocomplete="off"
                  value="{{ old('nama_kegiatan', $anggaran->nama_kegiatan) }}">
                @error('nama_kegiatan')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="pagu" class="text-sm" class="text-sm">Pagu</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('pagu')
										is-invalid
									@enderror"
                    id="pagu" placeholder="Masukkan nominal pagu" name="pagu"
                    value="{{ old('pagu', $anggaran->pagu) }}" autocomplete="off">
                </div>
                @error('pagu')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

            </div>
          </div>

          <a href="{{ route('anggaran.index') }}">
            <button type="button" class="btn btn-sm btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
        </form>
      </div>
    </div>

    <div class="text-center mt-3 text-sm">
      <i class="text-muted italic text-sm">Diubah {{ $anggaran->updated_at->diffForHumans() }}</i>
    </div>

  @section('scripts')
    <script>
      const inputHonor = document.getElementById('pagu');

      // Format langsung saat halaman edit dibuka
      document.addEventListener("DOMContentLoaded", function() {
        let value = inputHonor.value.replace(/[^0-9]/g, '');
        if (value) {
          inputHonor.value = formatRupiah(value, 'Rp ');
        }
      });

      // Saat user mengetik
      inputHonor.addEventListener('input', function(e) {
        let value = this.value.replace(/[^0-9]/g, ''); // hanya angka
        if (value) {
          this.value = formatRupiah(value, 'Rp ');
        } else {
          this.value = '';
        }
      });

      function formatRupiah(angka, prefix) {
        let number_string = angka.toString(),
          sisa = number_string.length % 3,
          rupiah = number_string.substr(0, sisa),
          ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
          let separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }

        return prefix + rupiah;
      }
    </script>
  @endsection
@endsection
