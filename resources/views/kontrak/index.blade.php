@extends('layouts.template')

@section('content')
  <div class="row">

    {{-- button  --}}
    <div class="col-12">
      <a href="{{ route('kontrak.create') }}" class="btn btn-success mb-3">Tambah kontrak</a>
    </div>

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">
      <div class="card">
        <div class="card-header">

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>Mitra - NMS</th>
                <th>Dokumen Kontrak</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($kontrak as $index => $k)
                <tr>
                  <td>{{ $index + $kontrak->firstItem() }}</td>
                  <td>{{ $k->mitra->nama_lengkap }} - {{ $k->mitra->nms }}</td>
                  <td> <a href="{{ route('kontrak.file', $k->id) }}" class="btn btn-secondary btn-sm" target="_blank"
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
                  </td>
                  <td>
                    <a href="{{ route('kontrak.show', $k->id) }}" class="btn btn-info btn-sm" title="Detail">Detail</a>
                    <a href="{{ route('kontrak.edit', $k->id) }}" class="btn btn-warning btn-sm" title="Edit">Edit</a>
                    <x-confirm-delete action="{{ route('kontrak.destroy', $k->id) }}" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted text-sm">Tidak ada data dalam tabel</td>
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
