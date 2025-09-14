@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('anggaran.store') }}">
          @csrf
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode_anggaran">Kode akun anggaran</label>
                <input type="text" class="form-control @error('kode_anggaran')
									is-invalid
								@enderror"
                  id="kode_anggaran" name="kode_anggaran" placeholder="Masukkan kode anggaran" autocomplete="off"
                  value="{{ old('kode_anggaran') }}">
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
                  value="{{ old('nama_kegiatan') }}">
                @error('nama_kegiatan')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_lengkap">Pagu</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control @error('pagu')
										is-invalid
									@enderror" id="pagu"
                    placeholder="Masukkan nominal pagu" name="pagu" value="{{ old('pagu') }}" autocomplete="off" />
                </div>
                @error('pagu')
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
      const inputHonor = document.getElementById('pagu');

      inputHonor.addEventListener('input', function(e) {
        let value = this.value.replace(/[^0-9]/g, ''); // hanya angka
        if (value) {
          // Format ke Rupiah
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
