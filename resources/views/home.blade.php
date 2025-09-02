@extends('layouts.template')

@section('content')
  <div class="row">
    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $mitra }}</h3>

          <p>Mitra Terdaftar</p>
        </div>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-handshake-icon lucide-handshake">
            <path d="m11 17 2 2a1 1 0 1 0 3-3" />
            <path
              d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4" />
            <path d="m21 3 1 11h-2" />
            <path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3" />
            <path d="M3 4h8" />
          </svg>
        </div>
        <a href="{{ route('mitra.index') }}" class="small-box-footer">Lihat selengkapnya &raquo;</a>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $anggaran }}</h3>

          <p>Anggaran terdata</p>
        </div>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-hand-coins-icon lucide-hand-coins">
            <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17" />
            <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9" />
            <path d="m2 16 6 6" />
            <circle cx="16" cy="9" r="2.9" />
            <circle cx="6" cy="5" r="3" />
          </svg>
        </div>
        <a href="{{ route('mitra.index') }}" class="small-box-footer">Lihat selengkapnya &raquo;</a>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3>{{ $user }}</h3>

          <p>User terdaftar</p>
        </div>
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-users-icon lucide-users">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <circle cx="9" cy="7" r="4" />
          </svg>
        </div>
        <a href="{{ route('user.index') }}" class="small-box-footer">Lihat selengkapnya &raquo;</a>
      </div>
    </div>
  </div>
@endsection
