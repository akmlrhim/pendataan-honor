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
                <label for="kode_anggaran">Kode anggaran</label>
                <input type="text" class="form-control @error('kode_anggaran')
									is-invalid
								@enderror"
                  id="kode_anggaran" name="kode_anggaran" placeholder="Masukkan kode anggaran" autocomplete="off"
                  value="{{ old('kode_anggaran', $anggaran->kode_anggaran) }}">
                @error('kode_anggaran')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_kegiatan">Nama kegiatan</label>
                <input type="text" class="form-control @error('nama_kegiatan')
									is-invalid
								@enderror"
                  id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" autocomplete="off"
                  value="{{ old('nama_kegiatan', $anggaran->nama_kegiatan) }}">
                @error('nama_kegiatan')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_lengkap">Batas honor</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-banknote-icon lucide-banknote">
                        <rect width="20" height="12" x="2" y="6" rx="2" />
                        <circle cx="12" cy="12" r="2" />
                        <path d="M6 12h.01M18 12h.01" />
                      </svg>
                    </span>
                  </div>
                  <input type="text" inputmode="numeric"
                    class="form-control @error('batas_honor')
										is-invalid
									@enderror" id="batas_honor"
                    placeholder="Masukkan nominal batas honor" name="batas_honor"
                    value="{{ old('batas_honor', $anggaran->batas_honor) }}" autocomplete="off">
                </div>
                @error('batas_honor')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

            </div>
          </div>

          <a href="{{ route('anggaran.index') }}">
            <button type="button" class="btn btn-secondary">Kembali</button>
          </a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>

    </div>

  @section('scripts')
    <script>
      const inputHonor = document.getElementById('batas_honor');

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
