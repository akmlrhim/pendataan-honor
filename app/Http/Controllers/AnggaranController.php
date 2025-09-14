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
            'pagu' => preg_replace('/[^0-9]/', '', $request->pagu),
        ]);

        $request->validate([
            'kode_anggaran' => 'required|unique:anggaran,kode_anggaran',
            'nama_kegiatan' => 'required',
            'pagu' => 'required|numeric|min:0'
        ]);

        $created = Anggaran::create([
            'kode_anggaran' => Str::upper($request->kode_anggaran),
            'nama_kegiatan' => ucwords(strtolower($request->nama_kegiatan)),
            'pagu' => $request->pagu,
            'sisa_anggaran' => $request->pagu,
        ]);

        return $created
            ? redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil ditambahkan.')
            : redirect()->back()->with('error', 'Error.');
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
            'pagu' => preg_replace('/[^0-9]/', '', $request->pagu),
        ]);

        $request->validate([
            'kode_anggaran' => 'required|unique:anggaran,kode_anggaran,' . $anggaran->id,
            'nama_kegiatan' => 'required',
            'pagu' => 'required|numeric|min:0',
        ]);

        if ($request->pagu != $anggaran->pagu) {
            $selisih = $request->pagu - $anggaran->pagu;
            $sisaBaru = $anggaran->pagu + $selisih;

            $anggaran->sisa_anggaran = $sisaBaru;
        }

        $anggaran->kode_anggaran = Str::upper($request->kode_anggaran);
        $anggaran->nama_kegiatan = ucwords(strtolower($request->nama_kegiatan));
        $anggaran->pagu = $request->pagu;
        $updated = $anggaran->save();

        return $updated
            ?  redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil diperbarui.')
            : redirect()->back()->with('error', 'Error.');
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
