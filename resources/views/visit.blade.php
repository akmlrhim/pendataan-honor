@extends('layouts.template')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-sm text-nowrap text-sm">
            <thead class="bg-success">
              <tr>
                <th>#</th>
                <th>User</th>
                <th>IP Address</th>
                <th>Browser</th>
                <th>Login pada</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($visitor as $index => $row)
                <tr>
                  <td>{{ $index + $visitor->firstItem() }}</td>
                  <td>{{ $row->users->nama_lengkap ?? 'Guest' }}</td>
                  <td>{{ $row->ip ?? '-' }}</td>
                  <td>{{ $row->browser ?? '-' }}</td>
                  <td>{{ $row->created_at->translatedFormat('d F Y') }} -
                    {{ $row->created_at->translatedFormat('H:i:s') }}
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
          {{ $visitor->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
@endsection
