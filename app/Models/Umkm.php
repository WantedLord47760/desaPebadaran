<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'foto',
        'nama_penjual',
        'no_whatsapp',
        'kategori',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getWhatsappLinkAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->no_whatsapp);
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1);
        }
        return 'https://wa.me/' . $phone;
    }
}
