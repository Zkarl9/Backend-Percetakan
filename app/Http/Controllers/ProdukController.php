<?php

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
            \Log::info('Store request received', [
                'request' => $request->all(),
                'headers' => $request->headers->all()
            ]);

            $validator = validator($request->all(), [
                'nama' => 'required',
                'kategori' => 'required',
                'harga' => 'required|numeric|min:0|max:99999999.99',
                'deskripsi' => 'required',
                'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
                'gambar' => 'required|array|max:4'
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

            $gambarPaths = [];
            if ($request->hasFile('gambar')) {
                foreach ($request->file('gambar') as $gambar) {
                    $gambarPath = $gambar->store('public/uploads/produk');
                    $gambarPaths[] = str_replace('public/', '', $gambarPath);
                }
            }

            $produk = Produk::create([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'gambar' => json_encode($gambarPaths) // Store as JSON array
            ]);

            $this->logActivity('create', 'Menambahkan produk baru: ' . $produk->nama, $produk);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan'
                ]);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Error creating product:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan produk.'])->withInput();
        }
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        try {
            \Log::info('Update request received', [
                'request' => $request->all(),
                'headers' => $request->headers->all(),
                'isAjax' => $request->ajax(),
                'acceptHeader' => $request->header('Accept')
            ]);

            $validator = validator($request->all(), [
                'nama' => 'required',
                'kategori' => 'required',
                'harga' => 'required|numeric',
                'deskripsi' => 'required',
                'gambar' => $request->hasFile('gambar') ? 'image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048' : 'nullable'
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->header('Accept') === 'application/json') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => $validator->errors()
                    ], 422)->header('Content-Type', 'application/json');
                }
                return back()->withErrors($validator)->withInput();
            }

            $data = [
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
            ];

            $currentImages = $produk->gambar ? json_decode($produk->gambar, true) : [];
            $deletedImages = $request->input('deleted_images', []);
            $newImagePaths = [];

            // Hapus gambar yang dipilih untuk dihapus
            foreach ($deletedImages as $deletedImage) {
                $key = array_search($deletedImage, $currentImages);
                if ($key !== false) {
                    Storage::delete('public/' . $currentImages[$key]);
                    unset($currentImages[$key]);
                }
            }
            // Re-index array setelah penghapusan
            $currentImages = array_values($currentImages);

            // Tambahkan gambar baru jika ada
            if ($request->hasFile('gambar')) {
                foreach ($request->file('gambar') as $gambar) {
                    $gambarPath = $gambar->store('public/uploads/produk');
                    $newImagePaths[] = str_replace('public/', '', $gambarPath);
                }
            }

            // Gabungkan gambar yang tersisa dengan gambar baru
            $allImages = array_merge($currentImages, $newImagePaths);
            
            // Pastikan tidak lebih dari 4 gambar
            if (count($allImages) > 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total gambar tidak boleh lebih dari 4'
                ], 422)->header('Content-Type', 'application/json');
            }

            $data['gambar'] = json_encode($allImages);

            $produk->update($data);
            
            $this->logActivity('update', 'Mengupdate produk: ' . $produk->nama, $produk);

            if ($request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil diperbarui',
                    'data' => $produk
                ])->header('Content-Type', 'application/json');
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');

        } catch (\Exception $e) {
            \Log::error('Error updating product: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'headers' => $request->headers->all()
            ]);
            
            if ($request->ajax() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage()
                ], 500)->header('Content-Type', 'application/json');
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan produk.'])->withInput();
        }
    }

    public function getImage(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        if (!$produk->gambar) {
            return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
        }
        
        $images = json_decode($produk->gambar, true);
        $imageData = [];
        
        foreach ($images as $image) {
            $imageData[] = [
                'url' => asset('storage/' . $image),
                'name' => basename($image)
            ];
        }
        
        return response()->json([
            'images' => $imageData
        ]);
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }
        
        $nama = $produk->nama;
        $produk->delete();
        
        $this->logActivity('delete', 'Menghapus produk: ' . $nama, $produk);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
