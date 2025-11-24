<?php
// app/Http/Controllers/ProdukController.php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class ProdukController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        try {
            \Log::info('=== START UPLOAD ===');
            \Log::info('Request data:', $request->except('gambar'));
            \Log::info('Has files:', ['has_file' => $request->hasFile('gambar')]);
            
            $validator = validator($request->all(), [
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string',
                'harga' => 'required|numeric|min:0|max:99999999.99',
                'deskripsi' => 'required|string',
                'gambar' => 'required|array|min:1|max:4',
                'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048'
            ], [
                'nama.required' => 'Nama produk wajib diisi',
                'kategori.required' => 'Kategori wajib dipilih',
                'harga.required' => 'Harga wajib diisi',
                'harga.numeric' => 'Harga harus berupa angka',
                'deskripsi.required' => 'Deskripsi wajib diisi',
                'gambar.required' => 'Minimal 1 gambar harus diupload',
                'gambar.array' => 'Format gambar tidak valid',
                'gambar.max' => 'Maksimal 4 gambar',
                'gambar.*.image' => 'File harus berupa gambar',
                'gambar.*.mimes' => 'Format gambar: jpeg, png, jpg, gif, bmp, webp, svg',
                'gambar.*.max' => 'Ukuran gambar maksimal 2MB'
            ]);

            if ($validator->fails()) {
                \Log::warning('Validation failed:', $validator->errors()->toArray());
                
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            $gambarPaths = [];
            
            if ($request->hasFile('gambar')) {
                foreach ($request->file('gambar') as $index => $gambar) {
                    \Log::info("Uploading file {$index}:", [
                        'name' => $gambar->getClientOriginalName(),
                        'size' => $gambar->getSize(),
                        'mime' => $gambar->getMimeType()
                    ]);

                    $filename = time() . '_' . uniqid() . '_' . $index . '.' . $gambar->getClientOriginalExtension();
                    $path = $gambar->storeAs('uploads/produk', $filename, 'public');
                    
                    if (!$path) {
                        throw new \Exception("Gagal menyimpan file: {$gambar->getClientOriginalName()}");
                    }
                    
                    \Log::info("File saved:", ['path' => $path]);
                    $gambarPaths[] = $path;
                }
            }

            if (empty($gambarPaths)) {
                throw new \Exception('Tidak ada gambar yang berhasil diupload');
            }

            \Log::info('All files uploaded:', $gambarPaths);

            $produk = Produk::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => json_encode($gambarPaths)
            ]);

            \Log::info('Product created:', ['id' => $produk->id, 'nama' => $produk->nama]);
            \Log::info('=== END UPLOAD ===');

            $this->logActivity('create', 'Menambahkan produk baru: ' . $produk->nama, $produk);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan',
                    'data' => $produk
                ], 200);
            }

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Exception $e) {
            \Log::error('=== UPLOAD ERROR ===');
            \Log::error('Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        try {
            \Log::info('=== START UPDATE ===');
            \Log::info('Product ID:', ['id' => $produk->id]);
            \Log::info('Request data:', $request->except('gambar'));

            $validator = validator($request->all(), [
                'nama' => 'required|string|max:255',
                'kategori' => 'required|string',
                'harga' => 'required|numeric|min:0',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|array|max:4',
                'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
                'deleted_images' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            $currentImages = $produk->gambar ? json_decode($produk->gambar, true) : [];
            $deletedImages = $request->input('deleted_images', []);

            \Log::info('Current images:', $currentImages);
            \Log::info('Deleted images:', $deletedImages);

            // PERBAIKAN: Hapus gambar yang ada di deleted_images
            foreach ($deletedImages as $deletedImage) {
                // Cari index gambar yang akan dihapus
                $key = array_search($deletedImage, $currentImages);
                
                if ($key !== false) {
                    // Hapus file dari storage
                    if (Storage::disk('public')->exists($deletedImage)) {
                        Storage::disk('public')->delete($deletedImage);
                        \Log::info('Deleted file:', ['file' => $deletedImage]);
                    }
                    // Hapus dari array
                    unset($currentImages[$key]);
                }
            }

            // Reset array index setelah menghapus
            $currentImages = array_values($currentImages);

            // Upload gambar baru
            $newImages = [];
            if ($request->hasFile('gambar')) {
                foreach ($request->file('gambar') as $index => $gambar) {
                    $filename = time() . '_' . uniqid() . '_' . $index . '.' . $gambar->getClientOriginalExtension();
                    $path = $gambar->storeAs('uploads/produk', $filename, 'public');
                    
                    if ($path) {
                        $newImages[] = $path;
                        \Log::info('New file uploaded:', ['path' => $path]);
                    }
                }
            }

            // Gabungkan gambar lama dan baru
            $allImages = array_merge($currentImages, $newImages);

            // Validasi total gambar
            if (count($allImages) > 4) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Total gambar tidak boleh lebih dari 4'
                    ], 422);
                }
                return back()->withErrors(['gambar' => 'Total gambar tidak boleh lebih dari 4']);
            }

            \Log::info('Final images:', $allImages);

            // Update produk
            $produk->update([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => json_encode($allImages)
            ]);

            \Log::info('Product updated successfully');
            \Log::info('=== END UPDATE ===');

            $this->logActivity('update', 'Mengupdate produk: ' . $produk->nama, $produk);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil diperbarui',
                    'data' => $produk
                ], 200);
            }

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil diperbarui');

        } catch (\Exception $e) {
            \Log::error('=== UPDATE ERROR ===');
            \Log::error('Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function getImage(Request $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);
            
            if (!$produk->gambar) {
                return response()->json(['images' => []]);
            }
            
            $images = json_decode($produk->gambar, true);
            $imageData = [];
            
            foreach ($images as $image) {
                $imageData[] = [
                    'url' => asset('storage/' . $image),
                    'name' => basename($image),
                    'path' => $image  // Ini yang penting untuk penghapusan
                ];
            }
            
            \Log::info('Images fetched:', ['count' => count($imageData), 'data' => $imageData]);
            
            return response()->json(['images' => $imageData]);
        } catch (\Exception $e) {
            \Log::error('Error fetching images:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
        }
    }

    public function destroy(Produk $produk)
    {
        try {
            if ($produk->gambar) {
                $images = json_decode($produk->gambar, true);
                foreach ($images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            $nama = $produk->nama;
            $produk->delete();
            
            $this->logActivity('delete', 'Menghapus produk: ' . $nama, $produk);

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting product:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal menghapus produk']);
        }
    }

    // ==================== API METHODS ====================
    
    public function apiIndex(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 15);

            $query = Produk::query();

            // Filter by kategori
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->input('kategori'));
            }

            // Search by product name
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where('nama', 'like', "%{$search}%");
            }

            $produk = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

            // Transform data to include image URLs
            $data = $produk->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'deskripsi' => $item->deskripsi,
                    'harga' => $item->harga,
                    'kategori' => $item->kategori,
                    'gambar' => $item->gambar,
                    'gambar_urls' => $item->gambar_urls,
                    'gambar_utama' => $item->gambar_utama,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data produk berhasil diambil',
                'data' => $data,
                'pagination' => [
                    'current_page' => $produk->currentPage(),
                    'per_page' => $produk->perPage(),
                    'total' => $produk->total(),
                    'last_page' => $produk->lastPage(),
                    'from' => $produk->firstItem(),
                    'to' => $produk->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('API Error in apiIndex: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data produk',
                'error' => config('app.debug') ? $e->getMessage() : null,
                'data' => [],
                'pagination' => [
                    'total' => 0,
                    'per_page' => 15,
                    'current_page' => 1,
                    'last_page' => 1,
                ]
            ], 500);
        }
    }

    public function apiShow($id)
    {
        try {
            $produk = Produk::find($id);
            
            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan',
                    'data' => null
                ], 404);
            }

            $data = [
                'id' => $produk->id,
                'nama' => $produk->nama,
                'deskripsi' => $produk->deskripsi,
                'harga' => $produk->harga,
                'kategori' => $produk->kategori,
                'gambar' => $produk->gambar,
                'gambar_urls' => $produk->gambar_urls,
                'gambar_utama' => $produk->gambar_utama,
                'created_at' => $produk->created_at,
                'updated_at' => $produk->updated_at,
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Detail produk berhasil diambil',
                'data' => $data
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('API Error in apiShow: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail produk',
                'error' => config('app.debug') ? $e->getMessage() : null,
                'data' => null
            ], 500);
        }
    }

    public function apiStore(Request $request)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|array|max:4',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $gambarPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $filename = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $path = $gambar->storeAs('uploads/produk', $filename, 'public');
                $gambarPaths[] = $path;
            }
        }

        $produk = Produk::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => json_encode($gambarPaths)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'data' => $produk
        ], 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validator = validator($request->all(), [
            'nama' => 'nullable|string',
            'kategori' => 'nullable|string',
            'harga' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|array|max:4',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'deleted_images' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['nama', 'kategori', 'harga', 'deskripsi']);

        $currentImages = $produk->gambar ? json_decode($produk->gambar, true) : [];
        $deletedImages = $request->input('deleted_images', []);

        foreach ($deletedImages as $deleted) {
            $key = array_search($deleted, $currentImages);
            if ($key !== false) {
                Storage::disk('public')->delete($currentImages[$key]);
                unset($currentImages[$key]);
            }
        }
        $currentImages = array_values($currentImages);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $filename = time() . '_' . uniqid() . '.' . $gambar->getClientOriginalExtension();
                $path = $gambar->storeAs('uploads/produk', $filename, 'public');
                $currentImages[] = $path;
            }
        }

        $data['gambar'] = json_encode(array_slice($currentImages, 0, 4));
        $produk->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate',
            'data' => $produk
        ], 200);
    }

    public function apiDestroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar) {
            $images = json_decode($produk->gambar, true);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $produk->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}