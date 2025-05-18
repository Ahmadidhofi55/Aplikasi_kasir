<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class produk extends Model
{
    public $incrementing = false;    // UUID bukan auto increment
    protected $keyType   = 'string'; // UUID adalah string

    protected $fillable = [
        'barcode',
        'img',
        'name',
        'harga_beli',
        'harga_jual',
        'stock',
        'supliyer_id',
        'kategori_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Buat UUID otomatis
            }
        });
    }

    // Opsional: supaya route model binding pakai UUID
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function supliyer()
    {
        return $this->belongsTo(Supliyer::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
