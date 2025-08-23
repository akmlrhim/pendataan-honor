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
      @if ($kontrak->isEmpty())
        <div class="alert alert-warning">
          Data kontrak kosong.
        </div>
      @else
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data kontrak</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 300px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

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
            <table class="table table-hover table-sm text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Mitra - NMS</th>
                  <th>Tanggal kontrak</th>
                  <th>Tanggal surat</th>
                  <th>Tanggal BAST</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kontrak as $index => $k)
                  <tr>
                    <td>{{ $index + $kontrak->firstItem() }}</td>
                    <td>{{ $k->mitra->nama_lengkap }} - {{ $k->mitra->nms }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal_kontrak)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal_surat)->translatedFormat('d F Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($k->tanggal_bast)->translatedFormat('d F Y') }}</td>
                    <td>
                      <a href="{{ route('kontrak.show', $k->id) }}" class="btn btn-info btn-sm" title="Detail">Detail</a>
                      <a href="{{ route('kontrak.edit', $k->id) }}" class="btn btn-warning btn-sm" title="Edit">Edit</a>
                      <form action="{{ route('kontrak.destroy', $k->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" title="Hapus">
                          Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- /.card-body -->
          </div>

          <div class="mt-3 d-flex justify-content-end mx-3">
            {{ $kontrak->links() }}
          </div>
          <!-- /.card -->
        </div>
      @endif
    </div>
  </div>
@endsection
