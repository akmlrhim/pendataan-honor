@extends('layouts.template')

@section('content')
  {{-- flashdata --}}
  <x-alert />

  <div class="col-md-12">

    <div class="card card-primary">

      <!-- form start -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 border-right">
            <h5 class="mb-3">Data Pribadi</h5>
            <p class="text-muted text-sm">Pastikan informasi anda tetap valid dengan memperbarui data secara berkala.</p>
            <form method="POST" action="{{ route('profil.info') }}">
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label for="nama_lengkap" class="text-sm">Nama Lengkap</label>
                <input type="text" class="form-control form-control-sm @error('nama_lengkap') is-invalid @enderror"
                  id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}"
                  placeholder="Masukkan Nama Lengkap" autocomplete="off">
                @error('nama_lengkap')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="nip" class="text-sm">NIP</label>
                <input type="text" class="form-control form-control-sm @error('nip') is-invalid @enderror"
                  id="nip" name="nip" value="{{ old('nip', Auth::user()->nip) }}" placeholder="Masukkan NIP"
                  autocomplete="off">
                @error('nip')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="email" class="text-sm">Email</label>
                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                  id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                  placeholder="Masukkan Email" autocomplete="off">
                @error('email')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <button type="submit" class="btn btn-sm btn-primary">Simpan Profil</button>
            </form>
          </div>

          <div class="col-md-6 mt-4 mt-md-0">
            <h5 class="mb-3">Ubah Password</h5>
            <p class="text-muted text-sm">Gunakan kata sandi yang panjang dan acak untuk keamanan optimal.</p>
            <form method="POST" action="{{ route('profil.pwd') }}">
              @csrf
              @method('PATCH')

              <div class="form-group">
                <label for="current_password" class="text-sm">Password Saat Ini</label>
                <div class="input-group">
                  <input type="password"
                    class="form-control form-control-sm @error('current_password') is-invalid @enderror"
                    id="current_password" name="current_password" placeholder="Masukkan Password Saat Ini"
                    autocomplete="off">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-password"
                      data-target="current_password">
                      {{-- Default: eye-closed --}}
                      <span class="icon-eye">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" class="lucide lucide-eye-closed-icon">
                          <path d="m15 18-.722-3.25" />
                          <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                          <path d="m20 15-1.726-2.05" />
                          <path d="m4 15 1.726-2.05" />
                          <path d="m9 18 .722-3.25" />
                        </svg>
                      </span>
                    </button>
                  </div>
                </div>
                @error('current_password')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="new_password" class="text-sm">Password Baru</label>
                <div class="input-group">
                  <input type="password" class="form-control form-control-sm @error('new_password') is-invalid @enderror"
                    id="new_password" name="new_password" placeholder="Masukkan Password Baru" autocomplete="off">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-password"
                      data-target="new_password">
                      <span class="icon-eye">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" class="lucide lucide-eye-closed-icon">
                          <path d="m15 18-.722-3.25" />
                          <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                          <path d="m20 15-1.726-2.05" />
                          <path d="m4 15 1.726-2.05" />
                          <path d="m9 18 .722-3.25" />
                        </svg>
                      </span>
                    </button>
                  </div>
                </div>
                @error('new_password')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <div class="form-group">
                <label for="new_password_confirmation" class="text-sm">Konfirmasi Password</label>
                <div class="input-group">
                  <input type="password"
                    class="form-control form-control-sm @error('new_password_confirmation') is-invalid @enderror"
                    id="new_password_confirmation" name="new_password_confirmation"
                    placeholder="Masukkan Konfirmasi Password Baru" autocomplete="off">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-password"
                      data-target="new_password_confirmation">
                      <span class="icon-eye">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round" class="lucide lucide-eye-closed-icon">
                          <path d="m15 18-.722-3.25" />
                          <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                          <path d="m20 15-1.726-2.05" />
                          <path d="m4 15 1.726-2.05" />
                          <path d="m9 18 .722-3.25" />
                        </svg>
                      </span>
                    </button>
                  </div>
                </div>
                @error('new_password_confirmation')
                  <x-input-validation>{{ $message }}</x-input-validation>
                @enderror
              </div>

              <button type="submit" class="btn btn-sm btn-warning">Ubah Password</button>
            </form>
          </div>
        </div>

      </div>

    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll(".toggle-password").forEach(btn => {
        btn.addEventListener("click", function() {
          const targetId = this.getAttribute("data-target");
          const input = document.getElementById(targetId);
          const iconContainer = this.querySelector(".icon-eye");

          if (input.type === "password") {
            input.type = "text";
            iconContainer.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-eye-icon">
              <path d="M2.062 12.348a1 1 0 0 1 0-.696 
                       10.75 10.75 0 0 1 19.876 0 
                       1 1 0 0 1 0 .696 
                       10.75 10.75 0 0 1-19.876 0"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          `;
          } else {
            input.type = "password";
            iconContainer.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-eye-closed-icon">
              <path d="m15 18-.722-3.25"/>
              <path d="M2 8a10.645 10.645 0 0 0 20 0"/>
              <path d="m20 15-1.726-2.05"/>
              <path d="m4 15 1.726-2.05"/>
              <path d="m9 18 .722-3.25"/>
            </svg>
          `;
          }
        });
      });
    });
  </script>
@endsection
