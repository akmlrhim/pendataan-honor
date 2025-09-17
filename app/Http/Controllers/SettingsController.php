<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $title = 'Tambahan';
        $sett = Settings::select('uuid', 'key', 'value')->get();

        return view('tambahan.index', compact('title', 'sett'));
    }

    public function create()
    {
        $title = 'Tambahan';
        return view('tambahan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required'
        ]);

        Settings::create([
            'uuid' => Str::uuid(),
            'key' => Str::snake($request->key),
            'value' => $request->value
        ]);

        return redirect()->route('tambahan.index')->with('success', 'Berhasil disimpan.');
    }
}
