@extends('layouts.template')

@push('css-libs')
  <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #f9fafb;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      height: 2rem !important;
      display: flex;
      align-items: center;
      font-size: 1rem;
      color: #111827;
    }

    .select2-selection__rendered {
      color: #111827;
      font-size: 1rem;
    }

    .select2-selection__arrow {
      height: 100% !important;
      top: 0 !important;
      right: 0.75rem !important;
    }

    .select2-dropdown {
      border-radius: 0.5rem;
      font-size: 1rem;
    }
  </style>
@endpush

@section('content')
  @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
    <div class="btn-group mb-3" role="group" aria-label="Aksi Kontrak">
      <a href="{{ route('kontrak.create') }}" class="btn btn-sm btn-primary">
        Tambah Kontrak
      </a>
      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#printModal">
        Cetak
      </button>
      <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exportModal">
        Export
      </button>
    </div>
  @endif

  {{-- flashdata --}}
  <x-alert />

  <div class="row">
    <div class="col-sm-6">
      <form action="{{ route('kontrak.index') }}" method="GET">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-body">
            <div class="form-group align-items-center mb-0">
              <label for="mitra_id" class="me-2 text-sm text-primary mb-0">Cari Mitra:</label>
              <select name="mitra_id" id="mitra_id" class="form-control select2" onchange="this.form.submit()"
                style="max-width: 250px;">
                <option value="">-- Semua Mitra --</option>
                @foreach ($mitra as $m)
                  <option value="{{ $m->id }}" {{ request('mitra_id') == $m->id ? 'selected' : '' }}>
                    {{ $m->nama_lengkap }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="col-sm-6">
      <form action="{{ route('kontrak.index') }}" method="GET">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-body">
            <div class="form-group align-items-center mb-0">
              <label for="periode" class="me-2 text-sm text-primary mb-0">Periode:</label>
              <input type="month" name="periode" id="periode" class="form-control form-control-sm"
                onchange="this.form.submit()" onclick="this.showPicker()" value="{{ request('periode') }}">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap text-sm">
            <thead class="bg-success">
              <tr>
                <th>#</th>
                <th>Mitra - NMS</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($kontrak as $index => $k)
                <tr>
                  <td>{{ $index + $kontrak->firstItem() }}</td>
                  <td>{{ $k->mitra->nama_lengkap }} - {{ $k->mitra->nms }}</td>
                  <td>
                    @if (Auth::user()->role == 'umum')
                      <a href="{{ route('kontrak.file', $k->id) }}" class="btn btn-secondary btn-xs" target="_blank"
                        title="Cetak">
                        File
                      </a>
                    @endif

                    <a href="{{ route('kontrak.show', $k->id) }}" class="btn btn-info btn-xs" title="Detail">Detail</a>

                    @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
                      <a href="{{ route('kontrak.edit', $k->id) }}" class="btn btn-warning btn-xs"
                        title="Edit">Edit</a>
                      <x-confirm-delete action="{{ route('kontrak.destroy', $k->id) }}" />
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center text-muted text-sm">Tidak ada data dalam tabel</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- /.card-body -->
        </div>

        <div class="p-2">
          {{ $kontrak->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>

  {{-- modal print  --}}
  <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('kontrak.laporan') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="printModalLabel">Cetak Rekap</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label for="periode" class="text-sm">Periode</label>
            <input type="month" class="form-control form-control-sm" name="periode" id="periode" required
              onclick="this.showPicker()" />
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger btn-sm" title="Cetak menjadi PDF"> Cetak PDF</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  {{-- modal export  --}}
  <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('kontrak.export') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="printModalLabel"><i>Export</i> Kontrak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label for="periode" class="text-sm">Periode</label>
            <input type="month" class="form-control form-control-sm" name="periode" id="periode" required
              onclick="this.showPicker()" />
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-sm" title="Cetak menjadi PDF"> Cetak Excel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('select2/select2.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2({
        width: '100%'
      });
    })
  </script>
@endsection
