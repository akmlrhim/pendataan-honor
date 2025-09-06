@extends('layouts.template')

@section('content')
  <div class="row">

    {{-- button  --}}
    <div class="col-12">
      <a href="{{ route('mitra.create') }}" class="btn btn-success mb-3">Tambah Mitra</a>
    </div>

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">
      <div class="card">
        <div class="card-header">

          <div class="card-tools">
            <form action="{{ route('mitra.index') }}" method="GET" class="input-group input-group-sm"
              style="width: 300px;">
              <a href="{{ route('mitra.index') }}" class="btn btn-secondary btn-sm mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-refresh-cw">
                  <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                  <path d="M21 3v5h-5" />
                  <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                  <path d="M8 16H3v5" />
                </svg>
              </a>

              <input type="text" name="search" class="form-control" placeholder="Cari nama mitra"
                value="{{ request('search') }}">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                  </svg>
                </button>
              </div>
            </form>
          </div>


        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap">
            <thead>
              <tr>
                <th>#</th>
                <th>NMS</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($mitra as $index => $row)
                <tr>
                  <td>{{ $index + $mitra->firstItem() }}</td>
                  <td>{{ $row->nms }}</td>
                  <td>{{ $row->nama_lengkap }}</td>
                  <td>{{ $row->jenis_kelamin }}</td>
                  <td>{{ $row->alamat }}</td>
                  <td>
                    <a href="{{ route('mitra.edit', $row->id) }}" class="btn btn-info btn-sm">Edit</a>
                    <x-confirm-delete action="{{ route('mitra.destroy', $row->id) }}" />
                  </td>
                </tr>

              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted text-sm">Tidak ada data dalam tabel</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- /.card-body -->
        </div>

        <div class="p-2">
          {{ $mitra->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
@endsection
