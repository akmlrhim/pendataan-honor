<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Kontrak;
use App\Models\Anggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Kontrak';
        $mitra_id = $request->mitra_id;

        $kontrak = Kontrak::with('mitra')
            ->when($mitra_id, function ($query, $mitra_id) {
                $query->where('mitra_id', $mitra_id);
            })
            ->paginate(10);

        $kontrak->appends(['mitra_id' => $mitra_id]);

        $mitra = Mitra::all();

        return view('kontrak.index', compact('title', 'kontrak', 'mitra', 'mitra_id'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kontrak';
        $mitra = Mitra::select('id', 'nama_lengkap', 'nms')->get();
        $anggaran = Anggaran::select('id', 'kode_anggaran', 'nama_kegiatan', 'sisa_anggaran')->get();

        if ($mitra->isEmpty() && $anggaran->isEmpty()) {
            return redirect()->back()->with('error', 'Data anggaran atau mitra masih kosong silahkan isi terlebih dahulu.');
        }

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
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir'    => 'required|date',
            'keterangan'      => 'nullable|string',
            'tugas'           => 'required|array|min:1',
            'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
            'tugas.*.deskripsi_tugas' => 'required|string',
            'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
            'tugas.*.jumlah_target_dokumen'  => 'required|integer|min:1',
            'tugas.*.satuan'          => 'required|string|max:40',
            'tugas.*.harga_satuan'    => 'required|numeric|min:0',
        ]);

        // Hitung total honor dulu, sambil cek anggaran
        $totalHonor = 0;
        foreach ($request->tugas as $i => $tugasData) {
            $hargaTotalTugas = $tugasData['jumlah_dokumen'] * $tugasData['harga_satuan'];
            $totalHonor += $hargaTotalTugas;

            $anggaran = Anggaran::findOrFail($tugasData['anggaran_id']);

            if ($anggaran->sisa_anggaran < $hargaTotalTugas) {
                return redirect()->back()->withInput()->withErrors([
                    "tugas.$i.harga_satuan" => "Sisa anggaran tidak mencukupi."
                ]);
            }
        }

        // Simpan kontrak
        $lastNumber = Kontrak::max('nomor_kontrak');
        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        $kontrak = Kontrak::create([
            'nomor_kontrak'   => str_pad($nextNumber, 3, '0', STR_PAD_LEFT),
            'mitra_id'        => $request->mitra_id,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'tanggal_surat'   => $request->tanggal_surat,
            'tanggal_bast'    => $request->tanggal_bast,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
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
                'jumlah_target_dokumen'  => $tugasData['jumlah_target_dokumen'],
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
        $kontrak = Kontrak::with(['mitra', 'tugas.anggaran'])->findOrFail($id);
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

        if ($mitra->isEmpty() && $anggaran->isEmpty()) {
            return redirect()->back()->with('error', 'Data anggaran atau mitra masih kosong silahkan isi terlebih dahulu.');
        }

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
            'tanggal_mulai'   => 'required|date',
            'tanggal_berakhir' => 'required|date',
            'keterangan'      => 'nullable|string',

            'tugas'                   => 'required|array|min:1',
            'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
            'tugas.*.deskripsi_tugas' => 'required|string',
            'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
            'tugas.*.jumlah_target_dokumen' => 'required|integer|min:1',
            'tugas.*.satuan'          => 'required|string|max:40',
            'tugas.*.harga_satuan'    => 'required|numeric|min:0',
        ]);

        $kontrak = Kontrak::with('tugas')->findOrFail($id);

        $existingTugasIds = $kontrak->tugas()->pluck('id')->toArray();
        $requestTugasIds  = [];
        $totalHonor = 0;

        /**
         * =============================
         *  validasi anggaran
         * =============================
         */
        $anggaranMap = Anggaran::pluck('sisa_anggaran', 'id')->toArray();

        // kembalikan dulu semua alokasi lama (anggap kontrak ini belum ada)
        foreach ($kontrak->tugas as $oldTugas) {
            if (isset($anggaranMap[$oldTugas->anggaran_id])) {
                $anggaranMap[$oldTugas->anggaran_id] += $oldTugas->harga_total_tugas;
            }
        }

        // cek request tugas
        foreach ($request->tugas as $i => $t) {
            $newTotal = $t['jumlah_dokumen'] * $t['harga_satuan'];

            if (!isset($anggaranMap[$t['anggaran_id']])) {
                return back()->withInput()->withErrors([
                    "tugas.$i.anggaran_id" => "Anggaran tidak ditemukan."
                ]);
            }

            if ($newTotal > $anggaranMap[$t['anggaran_id']]) {
                return back()->withInput()->withErrors([
                    "tugas.$i.harga_satuan" =>
                    "Sisa anggaran tidak mencukupi"
                ]);
            }

            // kurangi simulasi
            $anggaranMap[$t['anggaran_id']] -= $newTotal;
        }

        /**
         * =============================
         *  eksekusi transaksi
         * =============================
         */
        DB::transaction(function () use ($request, $kontrak, $existingTugasIds, &$requestTugasIds, &$totalHonor) {
            foreach ($request->tugas as $t) {
                $newTotal = $t['jumlah_dokumen'] * $t['harga_satuan'];
                $anggaran = Anggaran::findOrFail($t['anggaran_id']);

                if (isset($t['id']) && in_array($t['id'], $existingTugasIds)) {
                    // Update tugas lama
                    $oldTugas = $kontrak->tugas()->find($t['id']);
                    $oldTotal = $oldTugas->harga_total_tugas;
                    $difference = $newTotal - $oldTotal;

                    $oldTugas->update([
                        'anggaran_id'       => $t['anggaran_id'],
                        'deskripsi_tugas'   => $t['deskripsi_tugas'],
                        'jumlah_dokumen'    => $t['jumlah_dokumen'],
                        'jumlah_target_dokumen' => $t['jumlah_target_dokumen'],
                        'satuan'            => $t['satuan'],
                        'harga_satuan'      => $t['harga_satuan'],
                        'harga_total_tugas' => $newTotal,
                    ]);

                    // update sisa anggaran
                    if ($difference > 0) {
                        $anggaran->decrement('sisa_anggaran', $difference);
                    } elseif ($difference < 0) {
                        $anggaran->increment('sisa_anggaran', abs($difference));
                    }

                    $requestTugasIds[] = $t['id'];
                } else {
                    // Tambah tugas baru
                    $newTugas = $kontrak->tugas()->create([
                        'anggaran_id'       => $t['anggaran_id'],
                        'deskripsi_tugas'   => $t['deskripsi_tugas'],
                        'jumlah_dokumen'    => $t['jumlah_dokumen'],
                        'jumlah_target_dokumen' => $t['jumlah_target_dokumen'],
                        'satuan'            => $t['satuan'],
                        'harga_satuan'      => $t['harga_satuan'],
                        'harga_total_tugas' => $newTotal,
                    ]);

                    $anggaran->decrement('sisa_anggaran', $newTotal);
                    $requestTugasIds[] = $newTugas->id;
                }

                $totalHonor += $newTotal;
            }

            // hapus tugas yang tidak ada di request
            $tugasToDelete = $kontrak->tugas()->whereNotIn('id', $requestTugasIds)->get();
            foreach ($tugasToDelete as $tugas) {
                $anggaran = Anggaran::find($tugas->anggaran_id);
                if ($anggaran) {
                    $anggaran->increment('sisa_anggaran', $tugas->harga_total_tugas);
                }
                $tugas->delete();
            }

            // update kontrak utama
            $kontrak->update([
                'mitra_id'        => $request->mitra_id,
                'tanggal_kontrak' => $request->tanggal_kontrak,
                'tanggal_surat'   => $request->tanggal_surat,
                'tanggal_bast'    => $request->tanggal_bast,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
                'keterangan'      => $request->keterangan,
                'total_honor'     => $totalHonor,
            ]);
        });

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

    public function fileKontrak($id)
    {
        $kontrak = Kontrak::with(['mitra', 'tugas.anggaran', 'tugas'])->findOrFail($id);
        $pdf = Pdf::loadView('kontrak.file_kontrak', compact('kontrak'))->setPaper('a4', 'portrait');

        return $pdf->stream('File Kontrak ' . $kontrak->nomor_kontrak . '.pdf');
    }
}
