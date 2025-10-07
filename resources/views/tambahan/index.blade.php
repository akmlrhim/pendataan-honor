@extends('layouts.template')

@section('content')
  <div class="row">

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">

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
