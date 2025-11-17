<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use Illuminate\Http\Request;
use App\Traits\LogsActivity;

class EcommerceController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $ecommerce = Ecommerce::all();
        return view('ecommerce.index', compact('ecommerce'));
    }

    public function create()
    {
        return view('ecommerce.create');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'platform' => 'required',
            'url_link' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $ecommerce = Ecommerce::create($request->only(['platform', 'url_link']));

        $this->logActivity('create', 'Menambahkan link e-commerce: ' . $ecommerce->platform, $ecommerce);

        return response()->json([
            'success' => true,
            'message' => 'E-Commerce berhasil ditambahkan'
        ]);
    }

    public function edit(Ecommerce $ecommerce)
    {
        return view('ecommerce.edit', compact('ecommerce'));
    }

    public function update(Request $request, Ecommerce $ecommerce)
    {
        try {
            // Log the request for debugging
            \Log::info('Update request received', [
                'request' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $validator = validator($request->all(), [
                'platform' => 'required',
                'url_link' => 'required|url'
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
                    'message' => 'E-Commerce berhasil diperbarui'
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
        // Hapus gambar jika ada
        if ($ecommerce->image && file_exists(public_path($ecommerce->image))) {
            unlink(public_path($ecommerce->image));
        }
        
        $platform = $ecommerce->platform;
        $ecommerce->delete();

        $this->logActivity('delete', 'Menghapus link e-commerce: ' . $platform, $ecommerce);

        return redirect()->route('ecommerce.index')
            ->with('success', 'E-Commerce berhasil dihapus');
    }
}