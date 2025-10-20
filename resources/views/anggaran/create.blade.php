@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card">
      <!-- form start -->
      <div class="card-body">
        <form method="POST" action="{{ route('anggaran.store') }}">
          @csrf
          <div class="row">
            <!-- Kiri -->
            <div class="col-sm-6">
              <div class="form-group">
                <label for="kode_anggaran" class="text-sm">Kode akun anggaran</label>
                <input type="text" class="form-control form-control-sm @error('kode_anggaran') is-invalid	@enderror"
                  id="kode_anggaran" name="kode_anggaran" placeholder="Masukkan kode anggaran" autocomplete="off"
                  value="{{ old('kode_anggaran') }}">
                @error('kode_anggaran')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="nama_kegiatan" class="text-sm">Nama kegiatan</label>
                <input type="text" class="form-control form-control-sm @error('nama_kegiatan') is-invalid	@enderror"
                  id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" autocomplete="off"
                  value="{{ old('nama_kegiatan') }}">
                @error('nama_kegiatan')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="pagu" class="text-sm">Pagu</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('pagu') is-invalid	@enderror" id="pagu-adv"
                    placeholder="Masukkan nominal pagu" name="pagu" value="{{ old('pagu') }}" autocomplete="off" />
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
  </div>
@endsection


@section('scripts')
  <script>
    const rupiahFields = ['pagu'];

    document.addEventListener("DOMContentLoaded", function() {
      rupiahFields.forEach(function(id) {
        const input = document.getElementById(id);
        if (input) {
          let value = input.value.replace(/[^0-9]/g, '');
          if (value) {
            input.value = formatRupiah(value, 'Rp ');
          }

          input.addEventListener('input', function(e) {
            let val = this.value.replace(/[^0-9]/g, '');
            this.value = val ? formatRupiah(val, 'Rp ') : '';
          });
        }
      });
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
