<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kukerta extends Model
{
    use HasFactory;

    protected $table = 'kukerta';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'pelaksana',        // JSON array
        'kategori',
        'thumbnail',
        'foto_dokumentasi', // JSON array
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'pelaksana'        => 'array',
        'foto_dokumentasi' => 'array',
        'tanggal_mulai'    => 'date',
        'tanggal_selesai'  => 'date',
        'is_published'     => 'boolean',
        'published_at'     => 'datetime',
    ];

    /**
     * Auto-generate slug from judul before saving.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->judul);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('judul')) {
                $model->slug = static::generateUniqueSlug($model->judul, $model->id);
            }
        });
    }

    private static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $slug     = Str::slug($judul);
        $original = $slug;
        $counter  = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /** Scope: only published records. */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /** Get first pelaksana name for display in lists. */
    public function getFirstPelaksanaAttribute(): string
    {
        $list = $this->pelaksana ?? [];
        return $list[0]['nama'] ?? '-';
    }

    /** Comma-separated list of pelaksana names. */
    public function getPelaksanaNamesAttribute(): string
    {
        return collect($this->pelaksana ?? [])->pluck('nama')->join(', ');
    }

    /** Available categories. */
    public static function categories(): array
    {
        return [
            'Infrastruktur',
            'Pendidikan',
            'Kesehatan',
            'Lingkungan',
            'Sosial Budaya',
            'Ekonomi',
            'Teknologi',
            'Pertanian',
            'Lainnya',
        ];
    }
}
