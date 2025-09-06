<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profil Saya';
        return view('profil', compact('title'));
    }

    public function info(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'nama_lengkap' => 'required|unique:users,nama_lengkap,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'nip' => 'required|unique:users,nip,' . $user->id,
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->nip = $request->nip;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Data pribadi anda berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak valid.',
            ])->withInput();
        }

        if ($request->current_password === $request->new_password) {
            return back()->withErrors([
                'new_password' => 'Password baru tidak boleh sama dengan password saat ini.',
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
