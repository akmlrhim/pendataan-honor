@extends('layouts.template')
@section('content')
  <div class="row">

    {{-- button  --}}
    <div class="col-12">
      <a href="{{ route('user.create') }}" class="btn btn-success mb-3">Tambah user</a>
    </div>

    {{-- flashdata --}}
    <x-alert />

    <div class="col-12">

      <div class="card">
        <div class="card-header">

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search" />

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
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>NIP</th>
                <th>Role</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($user as $index => $row)
                <tr>
                  <td>{{ $index + $user->firstItem() }}</td>
                  <td>{{ $row->nama_lengkap }}</td>
                  <td>{{ $row->email }}</td>
                  <td>{{ $row->nip }}</td>
                  <td>
                    {{ match ($row->role) {
                        'ketua_tim' => 'Ketua Tim',
                        'umum' => 'Umum',
                        'user' => 'User',
                    } }}
                  </td>
                  <td>
                    <a href="{{ route('user.edit', $row->id) }}" class="btn btn-info btn-sm">Edit</a>
                    <x-confirm-delete action="{{ route('user.destroy', $row->id) }}" />
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted text-sm">Tidak ada data dalam tabel</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="p-2">
          {{ $user->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
