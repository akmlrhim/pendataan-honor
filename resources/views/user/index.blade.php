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
      <form action="{{ route('user.index') }}" method="GET">
        <div class="card shadow-sm rounded-lg">
          <div class="card-body">
            <div class="form-row align-items-center">

              <!-- Filter Role -->
              <div class="col-md-3 mb-2">
                <label for="role" class="text-primary font-weight-bold">Role</label>
                <select name="role" id="role" class="custom-select" onchange="this.form.submit()">
                  <option value="">-- Semua Role --</option>
                  <option value="ketua_tim" {{ request('role') == 'ketua_tim' ? 'selected' : '' }}>Ketua Tim</option>
                  <option value="umum" {{ request('role') == 'umum' ? 'selected' : '' }}>Umum</option>
                  <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
              </div>

              <!-- Input Cari -->
              <div class="col-md-4 mb-2">
                <label for="keyword" class="text-primary font-weight-bold">Cari Nama / NIP</label>
                <input type="text" name="keyword" id="keyword" class="form-control" value="{{ request('keyword') }}"
                  placeholder="Masukkan Nama Lengkap atau NIP" autocomplete="off" />
              </div>

              <!-- Tombol -->
              <div class="col-md-4 mb-2 d-flex align-items-end">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-refresh-cw">
                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                    <path d="M21 3v5h-5" />
                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                    <path d="M8 16H3v5" />
                  </svg>
                </a>
              </div>

            </div>
          </div>
        </div>
      </form>
    </div>




    <div class="col-12">
      <div class="card">
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
