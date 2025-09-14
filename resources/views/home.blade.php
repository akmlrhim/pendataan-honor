@extends('layouts.template')

@section('content')
  <div class="row">
    <div class="col-lg-12 col-12">
      <div class="small-box bg-light shadow-sm rounded-lg">
        <div class="inner">
          <h5 class="text-primary">👋 Selamat Datang {{ auth()->user()->nama_lengkap }}, sebagai
            {{ match (auth()->user()->role) {
                'ketua_tim' => 'Ketua Tim',
                'umum' => 'Umum',
                'user' => 'User',
            } }}
          </h5>
        </div>
        <div class="icon">
          <!-- Icon tangan melambai -->
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="white" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hand">
            <path d="M4 15V9a2 2 0 1 1 4 0v6" />
            <path d="M8 13V7a2 2 0 1 1 4 0v6" />
            <path d="M12 11V5a2 2 0 1 1 4 0v8" />
            <path d="M16 12V7a2 2 0 1 1 4 0v10a7 7 0 0 1-7 7H9a7 7 0 0 1-7-7v-2" />
          </svg>
        </div>
      </div>
    </div>


    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h3 class="text-success">{{ $mitra }}</h3>

          <p class="text-success">Mitra Terdaftar</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h3 class="text-primary">{{ $anggaran }}</h3>

          <p class="text-primary">Anggaran terdata</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h3 class="text-danger">{{ $user }}</h3>

          <p class="text-danger">User terdaftar</p>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-2">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column">
              <span class="text-bold text-lg">{{ $totalVisits }}</span>
              <span>Jumlah Pengunjung Web</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
            <form action="{{ route('home') }}" method="GET">
              <select name="range" onchange="this.form.submit()" class="form-control custom-select w-auto">
                <option value="1" {{ request('range') == 1 ? 'selected' : '' }}>Hari Ini</option>
                <option value="3" {{ request('range') == 3 ? 'selected' : '' }}>3 Hari Terakhir</option>
                <option value="7" {{ request('range') == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ request('range') == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
              </select>
            </form>
            </p>
          </div>
          <canvas id="visitsChart" height="100px"></canvas>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/chart.js') }}"></script>
  <script>
    const ctx = document.getElementById('visitsChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!! json_encode($visitsPerDay->pluck('date')) !!},
        datasets: [{
          label: 'Pengunjung',
          data: {!! json_encode($visitsPerDay->pluck('count')) !!},
          borderColor: 'blue',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: true,
          tension: 0.3
        }]
      },
    });
  </script>
@endsection
