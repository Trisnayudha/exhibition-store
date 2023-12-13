<?php

namespace App\Models\MiningDirectory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRepresentative extends Model
{
    use HasFactory;
    protected $table = 'company_representative';
    protected $fillable = [
        'name', 'email', 'position',
    ];
}
