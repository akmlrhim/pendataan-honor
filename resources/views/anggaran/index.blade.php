@extends('layouts.template')

@section('content')
  <div class="row">

    {{-- button  --}}
    <div class="col-12">
      <a href="{{ route('anggaran.create') }}" class="btn btn-sm btn-success mb-3">Tambah Anggaran</a>
    </div>

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">

      <div class="card">
        <div class="card-header">

          <div class="card-tools">
            <form action="{{ route('anggaran.index') }}" method="GET" class="input-group input-group-sm"
              style="width: 300px;">
              <a href="{{ route('anggaran.index') }}" class="btn btn-secondary btn-sm mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-refresh-cw">
                  <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                  <path d="M21 3v5h-5" />
                  <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                  <path d="M8 16H3v5" />
                </svg>
              </a>

              <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode anggaran"
                value="{{ request('search') }}" autocomplete="off" onchange="this.form.submit()" />
            </form>
          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap text-sm">
            <thead class="bg-success">
              <tr>
                <th>#</th>
                <th>Kode Anggaran</th>
                <th>Nama Kegiatan</th>
                <th>Pagu</th>
                <th>Alokasi anggaran</th>
                <th>Sisa alokasi anggaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($anggaran as $index => $row)
                <tr>
                  <td>{{ $index + $anggaran->firstItem() }}</td>
                  <td>{{ $row->kode_anggaran }}</td>
                  <td>{{ $row->nama_kegiatan }}</td>
                  <td>Rp {{ number_format($row->pagu, 0, ',', '.') }}</td>
                  <td>
                    @if ($row->sisa_anggaran == 0)
                      <a href="{{ route('alocate.anggaran', $row->id) }}" class="btn btn-xs btn-warning">Alokasikan</a>
                    @else
                      Rp {{ number_format($row->alokasi_anggaran, 0, ',', '.') }}
                    @endif
                  </td>
                  <td>Rp. {{ number_format($row->sisa_anggaran, 0, ',', '.') ?? '-' }}</td>
                  <td>
                    <a href="{{ route('anggaran.edit', $row->id) }}" class="btn btn-xs btn-primary">Edit</a>
                    <x-confirm-delete action="{{ route('anggaran.destroy', $row->id) }}" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center text-muted text-sm">Tidak ada data dalam tabel</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- /.card-body -->
        </div>

        <div class="p-2">
          {{ $anggaran->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
@endsection
