<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Kontrak;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Visit;

class HomeController extends Controller
{
  public function index()
  {
    $title = 'Home';
    $mitra = Mitra::count();
    $anggaran = Anggaran::count();
    $user = User::count();
    $kontrak = Kontrak::where('periode', date('Y-m' . '-01'))->count();

    $range = request('range', 7);

    $visits = Visit::where('created_at', '>=', now()->subDays($range))->get();

    $totalVisits = $visits->count();

    $dates = collect();
    for ($i = $range - 1; $i >= 0; $i--) {
      $dates->push(now()->subDays($i)->format('Y-m-d'));
    }

    $visitsPerDay = $dates->map(function ($date) use ($visits) {
      $count = $visits->filter(fn($v) => $v->created_at->format('Y-m-d') === $date)->count();
      return [
        'date' => $date,
        'count' => $count,
      ];
    });

    return view('home', compact(
      'title',
      'mitra',
      'anggaran',
      'user',
      'kontrak',
      'totalVisits',
      'visitsPerDay',
      'range'
    ));
  }
}
