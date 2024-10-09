<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MineexpoExhibitor extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit jika berbeda dari konvensi Laravel
    protected $table = 'mineexpo_exhibitors';

    // Tentukan kolom-kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'exhid',
        'address',
        'phone',
        'website',
        'description',
        'emails',
        'categories',
        'linkedin',
        'instagram',
        'facebook',
        'name'
    ];

    // Tentukan kolom yang bertipe JSON
    protected $casts = [
        'emails' => 'array', // Kolom JSON untuk menyimpan email
        'categories' => 'array', // Kolom JSON untuk menyimpan kategori
    ];
}
