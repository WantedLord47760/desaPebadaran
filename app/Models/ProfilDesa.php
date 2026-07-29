<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    use HasFactory;

    protected $table = 'profil_desa';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue($key, $default = null)
    {
        $profil = static::where('key', $key)->first();
        return $profil ? $profil->value : $default;
    }
}
