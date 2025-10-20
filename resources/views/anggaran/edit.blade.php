@extends('layouts.template')

@section('content')
  <div class="col-md-12">
    <div class="card card-primary">

      <div class="card-body">
        <form method="POST" action="{{ route('anggaran.update', $anggaran->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
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
                <input type="text" class="form-control form-control-sm @error('nama_kegiatan')	is-invalid	@enderror"
                  id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan nama kegiatan" autocomplete="off"
                  value="{{ old('nama_kegiatan', $anggaran->nama_kegiatan) }}">
                @error('nama_kegiatan')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="pagu" class="text-sm">Pagu</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('pagu') is-invalid	@enderror" id="pagu"
                    placeholder="Masukkan nominal pagu" name="pagu" value="{{ old('pagu', $anggaran->pagu) }}"
                    autocomplete="off">
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
      <small class="text-muted italic">Anggaran diubah
        {{ $anggaran->anggaran_diperbarui->diffForHumans() ?? '-' }}</small>
    </div>
  </div>


  {{-- Advance Edit  --}}
  <div class="col-md-12 mt-4">
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title"><strong>ADVANCE EDIT</strong></h3>
        <br />
        <small>Gunakan bagian form ini untuk memperbaiki kesalahan input alokasi anggaran, dibagian ini anda juga bisa
          memperbaiki sisa anggaran dan juga pagu (perubahan pagu dibagian ini tidak menambahkan nominal ke alokasi dan
          sisa anggaran).</small>
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route('advance.edit.anggaran', $anggaran->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="alokasi_anggaran" class="text-sm">Alokasi anggaran</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('alokasi_anggaran') is-invalid	@enderror"
                    id="alokasi_anggaran" placeholder="Masukkan nominal alokasi anggaran" name="alokasi_anggaran"
                    value="{{ old('alokasi_anggaran', $anggaran->alokasi_anggaran) }}" autocomplete="off">
                </div>
                @error('alokasi_anggaran')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="sisa_anggaran" class="text-sm">Sisa anggaran</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('pagu') is-invalid	@enderror" id="sisa_anggaran"
                    placeholder="Masukkan sisa anggaran" name="sisa_anggaran"
                    value="{{ old('sisa_anggaran', $anggaran->sisa_anggaran) }}" autocomplete="off">
                </div>
                @error('sisa_anggaran')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pagu" class="text-sm">Pagu</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control form-control-sm @error('pagu') is-invalid	@enderror" id="pagu_adv"
                    placeholder="Masukkan nominal pagu" name="pagu" value="{{ old('pagu', $anggaran->pagu) }}"
                    autocomplete="off">
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
    const rupiahFields = ['pagu', 'alokasi_anggaran', 'sisa_anggaran', 'pagu_adv'];

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
