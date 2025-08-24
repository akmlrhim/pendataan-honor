<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Kontrak;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $anggaran = Anggaran::select('id', 'kode_anggaran', 'nama_kegiatan', 'sisa_anggaran')->get();
        return view('kontrak.create', compact('title', 'mitra', 'anggaran'));
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
            'tugas'           => 'required|array|min:1',
            'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
            'tugas.*.deskripsi_tugas' => 'required|string',
            'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
            'tugas.*.satuan'          => 'required|string|max:40',
            'tugas.*.harga_satuan'    => 'required|numeric|min:0',
        ]);

        // Hitung total honor dulu, sambil cek anggaran
        $totalHonor = 0;
        foreach ($request->tugas as $tugasData) {
            $hargaTotalTugas = $tugasData['jumlah_dokumen'] * $tugasData['harga_satuan'];
            $totalHonor += $hargaTotalTugas;

            $anggaran = Anggaran::findOrFail($tugasData['anggaran_id']);
            if ($anggaran->sisa_anggaran < $hargaTotalTugas) {
                return redirect()->back()->withInput()->with('error', "Sisa anggaran untuk {$anggaran->nama_kegiatan} tidak mencukupi.");
            }
        }

        // Simpan kontrak
        $kontrak = Kontrak::create([
            'mitra_id'        => $request->mitra_id,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_surat'   => $request->tanggal_surat,
            'tanggal_bast'    => $request->tanggal_bast,
            'keterangan'      => $request->keterangan,
            'total_honor'     => $totalHonor,
        ]);

        // Simpan tugas + update anggaran
        foreach ($request->tugas as $tugasData) {
            $hargaTotalTugas = $tugasData['jumlah_dokumen'] * $tugasData['harga_satuan'];

            $kontrak->tugas()->create([
                'anggaran_id'       => $tugasData['anggaran_id'],
                'deskripsi_tugas'   => $tugasData['deskripsi_tugas'],
                'jumlah_dokumen'    => $tugasData['jumlah_dokumen'],
                'satuan'            => $tugasData['satuan'],
                'harga_satuan'      => $tugasData['harga_satuan'],
                'harga_total_tugas' => $hargaTotalTugas,
            ]);

            $anggaran = Anggaran::find($tugasData['anggaran_id']);
            $anggaran->decrement('sisa_anggaran', $hargaTotalTugas);
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
        $anggaran = Anggaran::select('id', 'kode_anggaran', 'nama_kegiatan', 'sisa_anggaran')->get();
        return view('kontrak.edit', compact('title', 'kontrak', 'mitra', 'anggaran'));
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

            // validasi tugas
            'tugas'                   => 'required|array|min:1',
            'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
            'tugas.*.deskripsi_tugas' => 'required|string',
            'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
            'tugas.*.satuan'          => 'required|string|max:40',
            'tugas.*.harga_satuan'    => 'required|numeric|min:0',
        ]);

        $kontrak = Kontrak::with('tugas')->findOrFail($id);

        // --- 1. Kembalikan dulu sisa_anggaran dari tugas lama ---
        foreach ($kontrak->tugas as $oldTugas) {
            $anggaran = Anggaran::find($oldTugas->anggaran_id);
            $anggaran->increment('sisa_anggaran', $oldTugas->harga_total_tugas);
        }

        // --- 2. Update kontrak utama ---
        $kontrak->update([
            'mitra_id'        => $request->mitra_id,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_surat'   => $request->tanggal_surat,
            'tanggal_bast'    => $request->tanggal_bast,
            'keterangan'      => $request->keterangan,
        ]);

        $existingTugasIds = $kontrak->tugas()->pluck('id')->toArray();
        $requestTugasIds  = [];
        $totalHonor = 0;

        // --- 3. Loop data tugas dari request ---
        foreach ($request->tugas as $t) {
            $hargaTotal = $t['jumlah_dokumen'] * $t['harga_satuan'];

            // cek sisa anggaran cukup atau tidak
            $anggaran = Anggaran::find($t['anggaran_id']);
            if ($anggaran->sisa_anggaran < $hargaTotal) {
                return back()->withInput()->with('error', "Sisa anggaran untuk {$anggaran->nama_kegiatan} tidak mencukupi.");
            }

            if (isset($t['id']) && in_array($t['id'], $existingTugasIds)) {
                // update tugas lama
                $kontrak->tugas()->where('id', $t['id'])->update([
                    'anggaran_id'       => $t['anggaran_id'],
                    'deskripsi_tugas'   => $t['deskripsi_tugas'],
                    'jumlah_dokumen'    => $t['jumlah_dokumen'],
                    'satuan'            => $t['satuan'],
                    'harga_satuan'      => $t['harga_satuan'],
                    'harga_total_tugas' => $hargaTotal,
                ]);
                $requestTugasIds[] = $t['id'];
            } else {
                // buat tugas baru
                $newTugas = $kontrak->tugas()->create([
                    'anggaran_id'       => $t['anggaran_id'],
                    'deskripsi_tugas'   => $t['deskripsi_tugas'],
                    'jumlah_dokumen'    => $t['jumlah_dokumen'],
                    'satuan'            => $t['satuan'],
                    'harga_satuan'      => $t['harga_satuan'],
                    'harga_total_tugas' => $hargaTotal,
                ]);
                $requestTugasIds[] = $newTugas->id;
            }

            // kurangi sisa anggaran sesuai tugas baru
            $anggaran->decrement('sisa_anggaran', $hargaTotal);

            $totalHonor += $hargaTotal;
        }

        // --- 4. Hapus tugas yang tidak ada di request ---
        $kontrak->tugas()->whereNotIn('id', $requestTugasIds)->delete();

        // --- 5. Update total_honor kontrak ---
        $kontrak->update(['total_honor' => $totalHonor]);

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kontrak = Kontrak::with('tugas')->findOrFail($id);

        // Kembalikan anggaran dari setiap tugas
        foreach ($kontrak->tugas as $tugas) {
            $anggaran = $tugas->anggaran;
            if ($anggaran) {
                $anggaran->increment('sisa_anggaran', $tugas->harga_total_tugas);
            }
        }

        // Hapus kontrak beserta tugasnya
        $kontrak->tugas()->delete();
        $deleted = $kontrak->delete();

        if (!$deleted) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kontrak.');
        }

        return redirect()->route('kontrak.index')->with('success', 'Kontrak berhasil dihapus dan anggaran dikembalikan.');
    }
}
