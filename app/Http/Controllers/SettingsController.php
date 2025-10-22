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

    // public function create()
    // {
    //     $title = 'Tambahan';
    //     return view('tambahan.create', compact('title'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'key' => 'required|unique:settings,key',
    //         'value' => 'required'
    //     ]);

    //     Settings::create([
    //         'uuid' => Str::uuid(),
    //         'key' => Str::snake($request->key),
    //         'value' => $request->value
    //     ]);

    //     return redirect()->route('tambahan.index')->with('success', 'Berhasil disimpan.');
    // }

    public function edit($uuid)
    {
        $title = 'Tambahan';
        $sett = Settings::where('uuid', $uuid)->first();
        return view('tambahan.edit', compact('sett', 'title'));
    }

    public function update($uuid, Request $req)
    {
        $sett = Settings::where('uuid', $uuid)->first();

        $req->validate([
            'value' => 'required'
        ]);

        $sett->value = $req->value;
        $sett->save();

        return redirect()->route('tambahan.index')->with('success', 'Berhasil diperbarui.');
    }
}
