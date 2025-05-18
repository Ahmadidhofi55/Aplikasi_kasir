<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class metode_pembayaran extends Model
{
    public $incrementing = false;       // UUID bukan auto increment
    protected $keyType = 'string';      // UUID adalah string

    protected $fillable = [
        'name',
        'img',
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

}
