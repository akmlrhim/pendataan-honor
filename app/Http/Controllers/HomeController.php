<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Home';
        $mitra = Mitra::count();
        $anggaran = Anggaran::count();
        $user = User::count();

        $range = request('range', 7);

        $visits = Visit::where('created_at', '>=', now()->subDays($range))
            ->get();

        // Total kunjungan
        $totalVisits = $visits->count();

        // Pengunjung unik
        $uniqueVisitors = $visits->map(function ($v) {
            return $v->user_id ?? $v->ip;
        })->unique()->count();

        // Statistik per hari
        $visitsPerDay = $visits->groupBy(fn($v) => $v->created_at->format('Y-m-d'))
            ->map(fn($group) => $group->map(function ($v) {
                return $v->user_id ?? $v->ip;
            })->unique()->count())
            ->map(function ($count, $date) {
                return ['date' => $date, 'count' => $count];
            })->values();

        return view('home', compact(
            'title',
            'mitra',
            'anggaran',
            'user',
            'totalVisits',
            'uniqueVisitors',
            'visitsPerDay',
            'range'
        ));
    }
}
