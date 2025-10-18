@extends('layouts.template')

@push('css-libs')
  <style>
    #visitsChart {
      width: 100% !important;
      height: 100% !important;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h2 class="text-success font-anton">{{ $mitra }}</h2>
          <p class="text-success text-sm">Mitra Terdaftar</p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h2 class="text-primary font-anton">{{ $anggaran }}</h2>
          <p class="text-primary text-sm">Anggaran terdata</p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h2 class="text-info font-anton">{{ $kontrak }}</h2>
          <p class="text-info text-sm">Kontrak {{ now()->translatedFormat('F Y') }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-light">
        <div class="inner">
          <h2 class="text-danger font-anton">{{ $user }}</h2>
          <p class="text-danger text-sm">User terdaftar</p>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-2">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column mb-0">
              <span class="text-lg font-weight-bold">{{ $totalVisits }}</span>
              <span class="text-sm">Pengunjung Web</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
            <form action="{{ route('home') }}" method="GET">
              <select name="range" onchange="this.form.submit()" class="custom-select text-sm">
                <option value="1" {{ request('range') == 1 ? 'selected' : '' }}>Hari Ini</option>
                <option value="3" {{ request('range') == 3 ? 'selected' : '' }}>3 Hari Terakhir</option>
                <option value="7" {{ request('range') == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ request('range') == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
              </select>
            </form>
            </p>
          </div>
          <div class="chart tab-pane">
            <canvas id="visitsChart" height="300"></canvas>
          </div>
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
          tension: 0.3,
          pointRadius: 4,
          pointBackgroundColor: 'rgba(54, 162, 235, 1)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Tanggal'
            }
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah Kunjungan'
            },
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
  </script>
@endsection
