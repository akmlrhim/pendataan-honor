@extends('layouts.template')

@push('css-libs')
  <link rel="stylesheet" href="{{ asset('select2/select2.css') }}">
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #f9fafb;
      border: 1px solid #d1d5db;
      border-radius: 0.5rem;
      height: 2.5rem !important;
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
  <div class="row">

    {{-- button  --}}
    @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
      <div class="col-12">
        <a href="{{ route('kontrak.create') }}" class="btn btn-success mb-3">Tambah kontrak</a>
      </div>
    @endif

    {{-- flashdata --}}
    <x-alert />

    <div class="col-sm-6">
      <form action="{{ route('kontrak.index') }}" method="GET">
        <div class="card shadow-sm border-0 rounded-lg">
          <div class="card-body">
            <div class="form-group align-items-center mb-0">
              <label for="mitra_id" class="me-2 text-primary mb-0">Cari Mitra:</label>
              <select name="mitra_id" id="mitra_id" class="form-select select2" onchange="this.form.submit()"
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


    <div class="col-12">
      <div class="card">
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap">
            <thead>
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
                      <a href="{{ route('kontrak.file', $k->id) }}" class="btn btn-secondary btn-sm" target="_blank"
                        title="Cetak">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" class="lucide lucide-printer-check-icon lucide-printer-check mr-2">
                          <path d="M13.5 22H7a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v.5" />
                          <path d="m16 19 2 2 4-4" />
                          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v2" />
                          <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6" />
                        </svg>
                        Cetak Kontrak
                      </a>
                    @endif

                    <a href="{{ route('kontrak.show', $k->id) }}" class="btn btn-info btn-sm" title="Detail">Detail</a>

                    @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
                      <a href="{{ route('kontrak.edit', $k->id) }}" class="btn btn-warning btn-sm"
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
