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
      @if ($mitra->isEmpty())
        <div class="mb-4">
          <div class="alert alert-warning border-0 shadow-sm" role="alert"
            style="border-left: 4px solid #ffc107 !important; background: #fff8e1;">
            <div class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-info-icon lucide-info text-warning mr-3">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 16v-4" />
                <path d="M12 8h.01" />
              </svg>
              <div>
                <strong class="text-warning">Info: </strong>
                <span class="text-dark text-sm">Data {{ $title }} kosong. Silakan tambahkan data
                  {{ $title }} terlebih dahulu.
                </span>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="card">
          <div class="card-header">

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search" />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                      fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                  <th>NMS</th>
                  <th>Nama Lengkap</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($mitra as $index => $row)
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
                @endforeach
              </tbody>
            </table>
            <!-- /.card-body -->
          </div>

          <div class="p-2">
            {{ $mitra->links() }}
          </div>
          <!-- /.card -->
        </div>
      @endif
    </div>
  </div>
@endsection
