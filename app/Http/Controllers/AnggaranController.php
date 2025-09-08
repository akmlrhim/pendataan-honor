<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Anggaran';
        $search = $request->input('search');

        $anggaran = Anggaran::when($search, function ($query, $search) {
            $query->where('kode_anggaran', 'like', "%{$search}%")
                ->orWhere('nama_kegiatan', 'like', "%{$search}%");
        })->paginate(10);

        $anggaran->appends(['search' => $search]);

        return view('anggaran.index', compact('title', 'anggaran', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Anggaran';
        return view('anggaran.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'batas_honor' => preg_replace('/[^0-9]/', '', $request->batas_honor),
        ]);

        $request->validate([
            'kode_anggaran' => 'required|unique:anggaran,kode_anggaran',
            'nama_kegiatan' => 'required',
            'batas_honor' => 'required|numeric|min:0',
        ]);

        $created = Anggaran::create([
            'kode_anggaran' => Str::upper($request->kode_anggaran),
            'nama_kegiatan' => ucwords(strtolower($request->nama_kegiatan)),
            'batas_honor' => $request->batas_honor,
            'sisa_anggaran' => $request->batas_honor,
        ]);

        if ($created) {
            return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data anggaran. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Edit Anggaran';
        $anggaran = Anggaran::findOrFail($id);
        return view('anggaran.edit', compact('title', 'anggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $anggaran = Anggaran::findOrFail($id);

        $request->merge([
            'batas_honor' => preg_replace('/[^0-9]/', '', $request->batas_honor),
        ]);

        $request->validate([
            'kode_anggaran' => 'required|unique:anggaran,kode_anggaran,' . $anggaran->id,
            'nama_kegiatan' => 'required',
            'batas_honor' => 'required|numeric|min:0',
        ]);

        $anggaran->kode_anggaran = Str::upper($request->kode_anggaran);
        $anggaran->nama_kegiatan = ucwords(strtolower($request->nama_kegiatan));
        $anggaran->batas_honor = $request->batas_honor;
        $updated = $anggaran->save();

        if ($updated) {
            return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data anggaran. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        $deleted = $anggaran->delete();

        if ($deleted) {
            return redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data anggaran. Silakan coba lagi.');
        }
    }
}
