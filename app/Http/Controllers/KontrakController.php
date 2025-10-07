<?php

namespace App\Http\Controllers;

use App\Exports\KontrakExport;
use App\Models\Mitra;
use App\Models\Kontrak;
use App\Models\Anggaran;
use App\Models\Settings;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Kontrak';
        $mitra_id = $request->mitra_id;
        $periode  = $request->periode; // input "YYYY-MM"

        $kontrak = Kontrak::with('mitra')
            ->when($mitra_id, function ($query, $mitra_id) {
                $query->where('mitra_id', $mitra_id);
            })
            ->when($periode, function ($query, $periode) {
                $tahun  = substr($periode, 0, 4);
                $bulan = substr($periode, 5, 2);

                $query->whereYear('periode', $tahun)
                    ->whereMonth('periode', $bulan);
            })
            ->paginate(10)
            ->appends($request->all());

        $mitra = Mitra::select('id', 'nama_lengkap', 'nms')->get();

        return view('kontrak.index', compact(
            'title',
            'mitra',
            'kontrak',
            'mitra_id',
            'periode'
        ));
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
        $periode = Carbon::createFromFormat('Y-m', $request->periode)->startOfMonth()->toDateString();

        $request->validate([
            'mitra_id'  => [
                'required',
                Rule::unique('kontrak', 'mitra_id')
                    ->where(fn($query) => $query->whereDate('periode', $periode)),
            ],
            'tanggal_kontrak' => 'required|date',
            'tanggal_surat'   => 'required|date',
            'tanggal_bast'    => 'required|date',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir'   => 'required|date|after_or_equal:tanggal_mulai',
            'periode' => 'required',
            'keterangan'      => 'nullable|string',
            'tugas'           => 'required|array|min:1',
            'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
            'tugas.*.deskripsi_tugas' => 'required|string',
            'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
            'tugas.*.jumlah_target_dokumen'  => 'required|integer|min:1',
            'tugas.*.satuan'          => 'required|string|max:40',
            'tugas.*.harga_satuan'    => 'required|numeric|min:0',
        ], [
            'mitra_id.unique' => 'Mitra ini sudah memiliki kontrak untuk periode tersebut.'
        ]);

        // Hitung total honor dulu, sambil cek anggaran
        $batasHonor = (int) Settings::where('key', 'batas_honor')->value('value');

        $totalHonor = 0;
        foreach ($request->tugas as $i => $tugasData) {

            if ($tugasData['jumlah_dokumen'] > $tugasData['jumlah_target_dokumen']) {
                return back()->withInput()->withErrors([
                    "tugas.$i.jumlah_dokumen" => "Jumlah dokumen melebihi target."
                ]);
            }

            $hargaTotalTugas = $tugasData['jumlah_dokumen'] * $tugasData['harga_satuan'];
            $totalHonor += $hargaTotalTugas;

            $anggaran = Anggaran::findOrFail($tugasData['anggaran_id']);

            if ($anggaran->sisa_anggaran < $hargaTotalTugas) {
                return redirect()->back()->withInput()->withErrors([
                    "tugas.$i.harga_satuan" => "Sisa anggaran tidak mencukupi."
                ]);
            }
        }

        // validasi total honor tidak boleh melebihi batas honor yg tlh di tetapkan 
        if ($totalHonor > $batasHonor) {
            return redirect()->back()->withInput()->with('error', "Total honor melebihi Rp " . number_format($batasHonor, 0, ',', '.'));
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
            'periode' => $periode,
            'keterangan'      => $request->keterangan,
            'total_honor'     => $totalHonor,
        ]);

        // Simpan tugas + update anggaran
        foreach ($request->tugas as $tugasData) {
            $hargaTotalTugas = $tugasData['jumlah_dokumen'] * $tugasData['harga_satuan'];

            $kontrak->tugas()->create([
                'anggaran_id'       => $tugasData['anggaran_id'],
                'deskripsi_tugas'   => Str::ucfirst($tugasData['deskripsi_tugas']),
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
        $periode = Carbon::createFromFormat('Y-m', $request->periode)->startOfMonth()->toDateString();

        $request->validate(
            [
                'mitra_id' => [
                    'required',
                    Rule::unique('kontrak', 'mitra_id')
                        ->where(fn($query) => $query->where('periode', $periode))
                        ->ignore($id)
                ],
                'tanggal_kontrak' => 'required|date',
                'tanggal_surat'   => 'required|date',
                'tanggal_bast'    => 'required|date',
                'tanggal_mulai'   => 'required|date',
                'tanggal_berakhir'   => 'required|date|after_or_equal:tanggal_mulai',
                'periode' => 'required|date_format:Y-m',
                'keterangan'      => 'nullable|string',

                // validasi tugas 
                'tugas'                   => 'required|array|min:1',
                'tugas.*.anggaran_id'     => 'required|exists:anggaran,id',
                'tugas.*.deskripsi_tugas' => 'required|string',
                'tugas.*.jumlah_dokumen'  => 'required|integer|min:1',
                'tugas.*.jumlah_target_dokumen' => 'required|integer|min:1',
                'tugas.*.satuan'          => 'required|string|max:40',
                'tugas.*.harga_satuan'    => 'required|numeric|min:0',
            ],
            [
                'mitra_id.unique' => 'Mitra ini sudah memiliki kontrak untuk periode tersebut.'
            ]
        );

        $kontrak = Kontrak::with('tugas')->findOrFail($id);

        $existingTugasIds = $kontrak->tugas()->pluck('id')->toArray();
        $requestTugasIds  = [];
        $totalHonor = 0;
        $batasHonor = (int) Settings::where('key', 'batas_honor')->value('value');

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

            if ($t['jumlah_dokumen'] > $t['jumlah_target_dokumen']) {
                return back()->withInput()->withErrors([
                    "tugas.$i.jumlah_dokumen" => "Jumlah dokumen melebihi target."
                ]);
            }

            $newTotal = $t['jumlah_dokumen'] * $t['harga_satuan'];

            if (!isset($anggaranMap[$t['anggaran_id']])) {
                return back()->withInput()->withErrors([
                    "tugas.$i.anggaran_id" => "Anggaran tidak ditemukan."
                ]);
            }

            if ($newTotal > $anggaranMap[$t['anggaran_id']]) {
                return back()->withInput()->withErrors([
                    "tugas.$i.harga_satuan" => "Sisa anggaran tidak mencukupi"
                ]);
            }

            // kurangi simulasi
            $anggaranMap[$t['anggaran_id']] -= $newTotal;
        }

        // validasi total honor tidak boleh melebihi batas honor yg tlh di tetapkan 
        if ($newTotal > $batasHonor) {
            return redirect()->back()->withInput()->with('error', "Total honor melebihi Rp " . number_format($batasHonor, 0, ',', '.'));
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
                        'deskripsi_tugas'   => Str::ucfirst($t['deskripsi_tugas']),
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
                        'deskripsi_tugas'   => Str::ucfirst($t['deskripsi_tugas']),
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
                'periode' => $request->periode . '-01',
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

        return redirect()->back()->with('success', 'Kontrak berhasil dihapus dan anggaran dikembalikan.');
    }

    public function fileKontrak($id)
    {
        $kepalaBps = Settings::where('key', 'kepala_bps_tapin')->value('value');
        $pjbPembuatKomit = Settings::where('key', 'pejebat_pembuat_komitmen')->value('value');
        $kontrak = Kontrak::with(['mitra', 'tugas.anggaran', 'tugas'])->findOrFail($id);
        $pdf = Pdf::loadView('kontrak.file_kontrak', compact('kontrak', 'kepalaBps', 'pjbPembuatKomit'))->setPaper('a4', 'portrait');

        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_text(
            280,   // posisi X (tengah halaman A4 = ~270px)
            20,    // posisi Y (20px dari atas)
            "- {PAGE_NUM} -", // format
            null,  // font (null = default)
            12,    // ukuran font
            [0, 0, 0] // warna hitam
        );

        return $pdf->stream('File Kontrak ' . $kontrak->nomor_kontrak . '.pdf');
    }

    public function report(Request $request)
    {
        $periode = $request->periode;
        $laporan = collect();

        if (!$periode) {
            return back()->with('error', 'Silahkan pilih periode terlebih dahulu.');
        }

        if ($periode) {
            [$tahun, $bulan] = explode('-', $periode);

            $laporan = Kontrak::with(['mitra', 'tugas.anggaran', 'tugas'])
                ->whereYear('periode', $tahun)
                ->whereMonth('periode', $bulan)
                ->get();

            if ($laporan->isEmpty()) {
                return back()->with('error', "Data dalam periode yang dipilih tidak ada.");
            }
        }

        $pdf = Pdf::loadView('kontrak.laporan', [
            'periode' => $periode,
            'laporan' => $laporan,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream("Laporan Kontrak_{$periode}.pdf");
    }

    public function export(Request $request)
    {
        $periode = $request->periode;

        if (!$periode) {
            return back()->with('error', 'Silahkan pilih periode terlebih dahulu.');
        }

        [$tahun, $bulan] = explode('-', $periode);

        $checkData = Kontrak::whereYear('periode', $tahun)->whereMonth('periode', $bulan)->exists();

        if (!$checkData) {
            return back()->with('error', "Data dalam periode yang dipilih tidak ada.");
        }

        return Excel::download(new KontrakExport($bulan, $tahun), "Kontrak_{$periode}" . time() . ".xlsx");
    }
}
