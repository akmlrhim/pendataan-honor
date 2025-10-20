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
			'anggaran_diperbarui' => now(),
			'sisa_anggaran' => 0,
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
			$anggaran->sisa_anggaran += $selisih;
			$anggaran->alokasi_anggaran += $selisih;
		}

		if ($request->pagu < $anggaran->pagu) {
			return redirect()->back()->withErrors(['pagu' => 'Pagu tidak boleh kurang dari pagu sebelumnya.']);
		}

		$anggaran->kode_anggaran = Str::upper($request->kode_anggaran);
		$anggaran->nama_kegiatan = ucwords(strtolower($request->nama_kegiatan));
		$anggaran->pagu = $request->pagu;
		$anggaran->anggaran_diperbarui = now();
		$updated = $anggaran->save();

		return $updated
			? redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil diperbarui.')
			: redirect()->back()->with('error', 'Error.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id)
	{
		$anggaran = Anggaran::findOrFail($id);
		$deleted = $anggaran->delete();

		return $deleted
			? redirect()->route('anggaran.index')->with('success', 'Data anggaran berhasil dihapus.')
			: redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data anggaran. Silakan coba lagi.');
	}


	public function editAnggaran($id)
	{
		$title = 'Alokasi';
		$anggaran = Anggaran::findOrFail($id);
		return view('anggaran.alokasi', compact('anggaran', 'title'));
	}

	public function alocateAnggaran(Request $request, $id)
	{
		$request->merge([
			'alokasi_anggaran' => preg_replace('/[^0-9]/', '', $request->alokasi_anggaran),
		]);

		$request->validate([
			'alokasi_anggaran' => 'required|numeric|min:1',
		]);

		$anggaran = Anggaran::findOrFail($id);

		if ($request->alokasi_anggaran > $anggaran->pagu) {
			return redirect()->back()->withErrors(['alokasi_anggaran' => 'Alokasi anggaran tidak boleh melebihi pagu.']);
		}

		$anggaran->alokasi_anggaran = $request->alokasi_anggaran;
		$anggaran->sisa_anggaran = $request->alokasi_anggaran;
		$updatedAnggaran = $anggaran->save();

		return $updatedAnggaran
			? redirect()->route('anggaran.index')->with('success', 'Anggaran sudah dialokasikan')
			:	back()->with('error', 'Error.');
	}

	public function advanceEdit(Request $request, $id)
	{
		$anggaran = Anggaran::findOrFail($id);

		$request->merge([
			'alokasi_anggaran' => preg_replace('/[^0-9]/', '', $request->alokasi_anggaran),
			'sisa_anggaran' => preg_replace('/[^0-9]/', '', $request->sisa_anggaran),
			'pagu' => preg_replace('/[^0-9]/', '', $request->pagu),
		]);

		$request->validate([
			'alokasi_anggaran' => 'required|numeric|min:1',
			'sisa_anggaran' => 'required|numeric|min:1',
			'pagu' => 'required|numeric|min:1',
		]);

		$anggaran->alokasi_anggaran = $request->alokasi_anggaran;
		$anggaran->sisa_anggaran = $request->sisa_anggaran;
		$anggaran->pagu = $request->pagu;
		$success = $anggaran->save();

		return $success
			? redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil diubah.')
			:	back()->with('error', 'Error.');
	}
}
