<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Mitra;
use Illuminate\Http\Request;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kontrak';
        $kontrak = Kontrak::with('mitra')->paginate(10);
        return view('kontrak.index', compact('title', 'kontrak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kontrak';
        $mitra = Mitra::select('id', 'nama_lengkap', 'nms')->get();
        return view('kontrak.create', compact('title', 'mitra'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mitra_id'        => 'required|exists:mitra,id',
            'tanggal_kontrak' => 'required|date',
            'tanggal_surat'   => 'required|date',
            'tanggal_bast'    => 'required|date',
            'keterangan'      => 'nullable|string',
        ]);

        $created =  Kontrak::create([
            'mitra_id'        => $request->mitra_id,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_surat'   => $request->tanggal_surat,
            'tanggal_bast'    => $request->tanggal_bast,
            'keterangan'      => $request->keterangan,
            'total_honor'   => 0,
        ]);

        if (!$created) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menambahkan kontrak.');
        }

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title = 'Detail Kontrak';
        $kontrak = Kontrak::with('mitra')->findOrFail($id);
        return view('kontrak.show', compact('title', 'kontrak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = 'Edit Kontrak';
        $kontrak = Kontrak::findOrFail($id);
        $mitra = Mitra::select('id', 'nama_lengkap', 'nms')->get();
        return view('kontrak.edit', compact('title', 'kontrak', 'mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mitra_id'        => 'required|exists:mitra,id',
            'tanggal_kontrak' => 'required|date',
            'tanggal_surat'   => 'required|date',
            'tanggal_bast'    => 'required|date',
            'keterangan'      => 'nullable|string',
        ]);

        $kontrak = Kontrak::findOrFail($id);
        $kontrak->mitra_id = $request->mitra_id;
        $kontrak->tanggal_kontrak = $request->tanggal_kontrak;
        $kontrak->tanggal_surat = $request->tanggal_surat;
        $kontrak->tanggal_bast = $request->tanggal_bast;
        $kontrak->keterangan = $request->keterangan;
        $updated = $kontrak->save();

        if (!$updated) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat mengupdate kontrak.');
        }

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kontrak = Kontrak::findOrFail($id);
        $deleted = $kontrak->delete();

        if (!$deleted) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kontrak.');
        }

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil dihapus.');
    }
}
