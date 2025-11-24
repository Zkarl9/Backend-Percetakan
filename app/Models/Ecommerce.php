<?php
// Backend: app/Models/Ecommerce.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecommerce extends Model
{
    use HasFactory;

    protected $table = 'ecommerce';
    
    protected $fillable = [
        'platform',
        'url_link',
    ];

    /**
     * Scope untuk query lengkap
     */
    public function scopeComplete($query)
    {
        return $query->select('id', 'platform', 'url_link');
    }
}