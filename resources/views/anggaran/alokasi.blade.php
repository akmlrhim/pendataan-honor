@extends('layouts.template')

@section('content')
  <div class="col-md-6">
    <div class="card card-primary">
      <div class="card-body">
        <form method="POST" action="{{ route('store.alocate.anggaran', $anggaran->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-sm-12">

              <div class="form-group">
                <label for="sisa_anggaran">Alokasikan sebesar</label>
                <div class="input-group">
                  <input type="text" inputmode="numeric"
                    class="form-control @error('sisa_anggaran') is-invalid @enderror" id="sisa_anggaran"
                    placeholder="Masukkan nominal" name="sisa_anggaran"
                    value="{{ old('sisa_anggaran', $anggaran->sisa_anggaran) }}" autocomplete="off">
                </div>
                @error('sisa_anggaran')
                  <small class="text-danger text-sm">{{ ucfirst($message) }}</small>
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

  <div class="col-md-6">
    <div class="mt-3 text-sm">
      <p class="text-muted">Diubah {{ $anggaran->updated_at->diffForHumans() }}</p>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    const inputHonor = document.getElementById('sisa_anggaran');

    document.addEventListener("DOMContentLoaded", function() {
      if (inputHonor) {
        let value = inputHonor.value.replace(/[^0-9]/g, '');
        if (value) {
          inputHonor.value = formatRupiah(value, 'Rp ');
        }
      }
    });

    inputHonor?.addEventListener('input', function(e) {
      let value = this.value.replace(/[^0-9]/g, '');
      this.value = value ? formatRupiah(value, 'Rp ') : '';
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
