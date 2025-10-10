@extends('layouts.template')

@section('content')
  <div class="row">
    <div class="col-12">
      {{-- box informasi  --}}
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Catatan!</h4>
        <p class="text-sm mb-0">
          Jika ingin mengubah batas honor, perhatikan penulisan nominal.
          <br>Gunakan angka tanpa titik pemisah dan tanpa awalan <strong>Rp</strong>.
          <br><em>Contoh: 500000 (bukan Rp.500.000)</em>
        </p>
      </div>


      <div class="card">
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap text-sm">
            <thead class="bg-success">
              <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($sett as $row)
                <tr>
                  <td>{{ $row->key }}</td>
                  <td>{{ $row->value }}</td>
                  <td>
                    <a href="{{ route('tambahan.edit', $row->uuid) }}" class="btn btn-xs btn-primary">Edit</a>
                    <x-confirm-delete action="{{ route('tambahan.destroy', $row->uuid) }}" />
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
        <!-- /.card -->
      </div>
    </div>
  </div>
@endsection
