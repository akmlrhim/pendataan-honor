@extends('layouts.template')

@section('content')
  <div class="row">

    {{-- button  --}}
    <div class="col-12">
      <a href="{{ route('anggaran.create') }}" class="btn btn-success mb-3">Tambah Anggaran</a>
    </div>

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">

      @if ($anggaran->isEmpty())
        <div class="alert alert-warning">
          Data anggaran kosong.
        </div>
      @else
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Anggaran</h3>

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
                  <th>Kode Anggaran</th>
                  <th>Nama Kegiatan</th>
                  <th>Batas Honor</th>
                  <th>Sisa Anggaran</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($anggaran as $index => $row)
                  <tr>
                    <td>{{ $index + $anggaran->firstItem() }}</td>
                    <td>{{ $row->kode_anggaran }}</td>
                    <td>{{ $row->nama_kegiatan }}</td>
                    <td>Rp {{ number_format($row->batas_honor, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row->sisa_anggaran, 0, ',', '.') }}</td>
                    <td>
                      <a href="{{ route('anggaran.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                      <form action="{{ route('anggaran.destroy', $row->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin hapus data?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <!-- /.card-body -->
          </div>

          <div class="mt-3 d-flex justify-content-end mx-3">
            {{ $anggaran->links() }}
          </div>
          <!-- /.card -->
        </div>
      @endif

    </div>
  </div>
@endsection
