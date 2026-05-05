<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|string|min:6',
            'role'            => 'required|in:superadmin,sales,agen,partner',
            'phone'           => 'nullable|string|max:20',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['password']        = Hash::make($validated['password']);
        $validated['commission_rate'] = $validated['commission_rate'] ?? 0;

        User::create($validated);
        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'role'            => 'required|in:superadmin,sales,agen,partner',
            'phone'           => 'nullable|string|max:20',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'password'        => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri.']);
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
