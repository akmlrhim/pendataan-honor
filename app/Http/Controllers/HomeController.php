<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Home';
        $mitra = Mitra::count();
        $anggaran = Anggaran::count();
        $user = User::count();

        return view('home', compact('title', 'mitra', 'anggaran', 'user'));
    }
}
