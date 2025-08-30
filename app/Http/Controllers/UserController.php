<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Pengguna';
        $user = User::where('id', '!=', Auth::id())->paginate(10);
        return view('user.index', compact('title', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna';
        return view('user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|unique:users,nama_lengkap,except,id',
            'email' => 'email|required|unique:users,email,except,id',
            'nip' => 'required|numeric|unique:users,nip,except,id',
            'jabatan' => 'required'
        ]);

        $created = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'password' => Hash::make('bpstapin25')
        ]);

        if ($created) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
        }

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $title = 'Edit Pengguna';
        $user = User::findOrFail($id);

        return view('user.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|unique:users,nama_lengkap,' . $id,
            'email' => 'email|required|unique:users,email,' . $id,
            'nip' => 'required|numeric|unique:users,nip,' . $id,
            'jabatan' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->jabatan = $request->jabatan;
        $updated = $user->save();

        if (!$updated) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan.');
        }

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
