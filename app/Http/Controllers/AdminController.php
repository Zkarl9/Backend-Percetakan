<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->latest('last_login')
            ->get();
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'is_active' => true,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin created successfully');
    }

    public function toggleStatus(User $admin)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $admin->is_active = !$admin->is_active;
        $admin->save();

        return back()->with('success', 'Admin status updated successfully');
    }
}