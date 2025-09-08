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

        // Ambil range dari request, default 7 hari
        $range = request('range', 7);

        // Total kunjungan sesuai filter periode
        $totalVisits = Visit::where('created_at', '>=', now()->subDays($range))->count();

        // Pengunjung unik sesuai filter periode
        $uniqueVisitors = Visit::select(DB::raw("
        COALESCE(CAST(user_id AS CHAR), ip) as visitor
    "))
            ->where('created_at', '>=', now()->subDays($range))
            ->distinct()
            ->count();

        // Statistik pengunjung per hari sesuai filter periode
        $visitsPerDay = Visit::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(DISTINCT COALESCE(CAST(user_id AS CHAR), ip)) as count')
        )
            ->where('created_at', '>=', now()->subDays($range))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

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
