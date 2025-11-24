<?php
// app/Http/Controllers/EcommerceController.php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class EcommerceController extends Controller
{
    use LogsActivity;

    // Web routes (untuk admin panel)
    public function index()
    {
        $ecommerce = Ecommerce::all();
        return view('ecommerce.index', compact('ecommerce'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'platform' => 'required|string|max:255',
            'url_link' => 'required|url|max:500',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $ecommerce = Ecommerce::create($request->only(['platform', 'url_link']));

        $this->logActivity('create', 'Menambahkan link e-commerce: ' . $ecommerce->platform, $ecommerce);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'E-Commerce berhasil ditambahkan',
                'data' => $ecommerce
            ], 201);
        }

        return redirect()->route('ecommerce.index')
            ->with('success', 'E-Commerce berhasil ditambahkan');
    }

    public function update(Request $request, Ecommerce $ecommerce)
    {
        try {
            $validator = validator($request->all(), [
                'platform' => 'required|string|max:255',
                'url_link' => 'required|url|max:500'
            ]);

            if ($validator->fails()) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->only(['platform', 'url_link']);
            $ecommerce->update($data);

            $this->logActivity('update', 'Mengupdate link e-commerce: ' . $ecommerce->platform, $ecommerce);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'E-Commerce berhasil diperbarui',
                    'data' => $ecommerce
                ]);
            }

            return redirect()->route('ecommerce.index')
                ->with('success', 'E-Commerce berhasil diperbarui');
        } catch (\Exception $e) {
            \Log::error('Error updating e-commerce:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Ecommerce $ecommerce)
    {
        $platform = $ecommerce->platform;
        $ecommerce->delete();

        $this->logActivity('delete', 'Menghapus link e-commerce: ' . $platform, $ecommerce);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'E-Commerce berhasil dihapus'
            ]);
        }

        return redirect()->route('ecommerce.index')
            ->with('success', 'E-Commerce berhasil dihapus');
    }

    // ============================================
    // API METHODS (untuk Frontend)
    // ============================================

    public function apiIndex()
    {
        try {
            $ecommerce = Ecommerce::complete()->get();
            
            return response()->json([
                'success' => true,
                'data' => $ecommerce
            ]);
        } catch (\Exception $e) {
            \Log::error('E-Commerce API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function apiStore(Request $request)
    {
        $validator = validator($request->all(), [
            'platform' => 'required|string|max:255',
            'url_link' => 'required|url|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $ecommerce = Ecommerce::create($request->only(['platform', 'url_link']));

            return response()->json([
                'success' => true,
                'message' => 'E-Commerce berhasil ditambahkan',
                'data' => $ecommerce
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan e-commerce: ' . $e->getMessage()
            ], 500);
        }
    }

    public function apiUpdate(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'platform' => 'required|string|max:255',
            'url_link' => 'required|url|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $ecommerce = Ecommerce::findOrFail($id);
            $ecommerce->update($request->only(['platform', 'url_link']));

            return response()->json([
                'success' => true,
                'message' => 'E-Commerce berhasil diperbarui',
                'data' => $ecommerce
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui e-commerce: ' . $e->getMessage()
            ], 500);
        }
    }

    public function apiDestroy($id)
    {
        try {
            $ecommerce = Ecommerce::findOrFail($id);
            $ecommerce->delete();

            return response()->json([
                'success' => true,
                'message' => 'E-Commerce berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus e-commerce: ' . $e->getMessage()
            ], 500);
        }
    }
}