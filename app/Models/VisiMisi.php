<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    use HasFactory;

    protected $table = 'visi_misi';

    protected $fillable = [
        'tipe',
        'konten',
        'urutan',
    ];

    public function scopeVisi($query)
    {
        return $query->where('tipe', 'visi');
    }

    public function scopeMisi($query)
    {
        return $query->where('tipe', 'misi');
    }
}
