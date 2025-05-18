<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Supliyer extends Model
{
    public $incrementing = false;    // UUID bukan auto increment
    protected $keyType   = 'string'; // UUID adalah string

    protected $fillable = [
        'name',
        'alamat',
        'telepon',
        'email',
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

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
