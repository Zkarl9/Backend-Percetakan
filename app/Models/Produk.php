<?php
// app/Models/Produk.php (BACKEND - Port 8001)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    
    protected $fillable = [
        'nama',
        'kategori',
        'harga',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    protected $appends = ['gambar_urls', 'gambar_utama'];

    /**
     * Accessor untuk mendapatkan array gambar URLs
     * Menggunakan url() untuk generate full URL dari backend
     */
    public function getGambarUrlsAttribute()
    {
        if (empty($this->attributes['gambar'])) {
            return [];
        }

        $gambarData = $this->attributes['gambar'];
        
        // Decode JSON string to array
        $paths = is_string($gambarData) ? json_decode($gambarData, true) : $gambarData;
        
        if (!is_array($paths)) {
            return [];
        }

        // Map paths to full URLs
        return array_map(function($path) {
            if (empty($path)) {
                return null;
            }

            // If already absolute URL, return as is
            if (preg_match('/^https?:\/\//i', $path)) {
                return $path;
            }

            // Generate full URL with backend domain
            // Remove leading slash from path
            $cleanPath = ltrim($path, '/');
            
            // Return full URL: http://localhost:8001/storage/uploads/produk/xxx.jpg
            return url('storage/' . $cleanPath);
            
        }, array_filter($paths)); // Remove null/empty values
    }

    /**
     * Accessor untuk mendapatkan gambar pertama (thumbnail)
     */
    public function getGambarUtamaAttribute()
    {
        $urls = $this->gambar_urls;
        return !empty($urls) ? $urls[0] : null;
    }
}