<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalProduk' => Produk::count(),
        ];

        // Get all activity logs for everyone
        $data['activities'] = ActivityLog::with('user')
            ->latest()
            ->paginate(50); // Menampilkan 50 data per halaman dengan pagination

        if (auth()->user()->role === 'superadmin') {
            $data['totalAdmin'] = User::where('role', 'admin')->count();
        }

        return view('dashboard', $data);
    }
}