<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'user')->latest()->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => 'required|string|max:50|unique:users',
            'program_studi' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun mahasiswa berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }
        return view('admin.mahasiswa.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'nim' => 'required|string|max:50|unique:users,nim,'.$user->id,
            'program_studi' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'is_active' => 'required|boolean',
        ]);

        $data = $request->only('name', 'email', 'nim', 'program_studi', 'phone', 'is_active');
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun mahasiswa berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'user') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Akun mahasiswa berhasil dihapus.');
    }
}
