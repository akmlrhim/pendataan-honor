<aside class="main-sidebar sidebar-light-success elevation-2">
  {{-- Logo --}}
  <a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset('img/logo_bps.webp') }}" loading="lazy" title="Logo" alt="Logo"
      class="brand-image img-circle" />
    <span class="brand-text font-weight-bold text-md">SIKOMBAT</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="{{ route('profil.index') }}" class="d-block font-weight-bold text-sm">
          {{ Auth::user()->nama_lengkap }}
        </a>
        <small class="d-block text-medium text-dark text-xs">
          {{ match (Auth::user()->role) {
              'ketua_tim' => 'Ketua Tim',
              'umum' => 'Umum',
              'user' => 'User',
              'admin' => 'Admin',
          } }}
        </small>
      </div>
    </div>


    <nav class="mt-2 text-sm">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-header text-muted">Utama</li>

        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard nav-icon">
              <rect width="7" height="9" x="3" y="3" rx="1" />
              <rect width="7" height="5" x="14" y="3" rx="1" />
              <rect width="7" height="9" x="14" y="12" rx="1" />
              <rect width="7" height="5" x="3" y="16" rx="1" />
            </svg>
            <p>
              Home
            </p>
          </a>
        </li>

        @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
          <li class="nav-item">
            <a href="{{ route('mitra.index') }}" class="nav-link {{ request()->routeIs('mitra.*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-handshake-icon lucide-handshake nav-icon">
                <path d="m11 17 2 2a1 1 0 1 0 3-3" />
                <path
                  d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4" />
                <path d="m21 3 1 11h-2" />
                <path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3" />
                <path d="M3 4h8" />
              </svg>
              <p>
                Mitra
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('anggaran.index') }}"
              class="nav-link {{ request()->routeIs('anggaran.*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-hand-coins-icon lucide-hand-coins nav-icon">
                <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
                <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9" />
                <path d="m2 16 6 6" />
                <circle cx="16" cy="9" r="2.9" />
                <circle cx="6" cy="5" r="3" />
              </svg>
              <p>
                Anggaran
              </p>
            </a>
          </li>
        @endif

        @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum')
          <li class="nav-item">
            <a href="{{ route('kontrak.index') }}"
              class="nav-link {{ request()->routeIs('kontrak.*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-signature-icon lucide-signature nav-icon">
                <path
                  d="m21 17-2.156-1.868A.5.5 0 0 0 18 15.5v.5a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1c0-2.545-3.991-3.97-8.5-4a1 1 0 0 0 0 5c4.153 0 4.745-11.295 5.708-13.5a2.5 2.5 0 1 1 3.31 3.284" />
                <path d="M3 21h18" />
              </svg>
              <p>
                Kontrak
              </p>
            </a>
          </li>
        @endif


        <li class="nav-header text-muted">Tambahan</li>

        @if (Auth::user()->role == 'ketua_tim' || Auth::user()->role == 'umum' || Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-users-icon lucide-users nav-icon">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <circle cx="9" cy="7" r="4" />
              </svg>
              <p>
                User
              </p>
            </a>
          </li>
        @endif

        <li class="nav-item">
          <a href="{{ route('profil.index') }}"
            class="nav-link {{ request()->routeIs('profil.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-user-round-cog-icon lucide-user-round-cog nav-icon">
              <path d="m14.305 19.53.923-.382" />
              <path d="m15.228 16.852-.923-.383" />
              <path d="m16.852 15.228-.383-.923" />
              <path d="m16.852 20.772-.383.924" />
              <path d="m19.148 15.228.383-.923" />
              <path d="m19.53 21.696-.382-.924" />
              <path d="M2 21a8 8 0 0 1 10.434-7.62" />
              <path d="m20.772 16.852.924-.383" />
              <path d="m20.772 19.148.924.383" />
              <circle cx="10" cy="8" r="5" />
              <circle cx="18" cy="18" r="3" />
            </svg>
            <p>
              Profil Anda
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="{{ route('tambahan.index') }}"
            class="nav-link {{ request()->routeIs('tambahan.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-badge-plus-icon lucide-badge-plus nav-icon">
              <path
                d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
              <line x1="12" x2="12" y1="8" y2="16" />
              <line x1="8" x2="16" y1="12" y2="12" />
            </svg>
            <p>
              Lainnya
            </p>
          </a>
        </li>

        @if (Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="{{ route('visit') }}" class="nav-link {{ request()->routeIs('visit.*') ? 'active' : '' }}">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-activity-icon lucide-activity nav-icon">
                <path
                  d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
              </svg>
              <p>
                Pengunjung Web
              </p>
            </a>
          </li>
        @endif

        <li class="nav-item">
          <a href="#" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout').submit();">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-log-out-icon lucide-log-out nav-icon text-danger">
              <path d="m16 17 5-5-5-5" />
              <path d="M21 12H9" />
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            </svg>
            <p class="text-danger">
              Logout
            </p>
          </a>

          <form id="logout" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
