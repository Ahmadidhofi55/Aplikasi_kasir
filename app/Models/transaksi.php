<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class transaksi extends Model
{
    public $incrementing = false;
    protected $keyType   = 'string';
    protected $table     = 'transaksis';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'total',
        'tunai',
        'tunai',
        'kembalian',
        'metode_pembayaran_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();

            // Buat kode transaksi otomatis
            $prefix = 'TRX' . now()->format('Ymd');
            $last   = self::where('kode_transaksi', 'like', $prefix . '%')
                ->orderBy('kode_transaksi', 'desc')->first();

            $number = 1;
            if ($last) {
                $lastNumber = (int) substr($last->kode_transaksi, -4);
                $number     = $lastNumber + 1;
            }

            $model->kode_transaksi = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi ke detail transaksi
    public function detailTransaksis()
    {
        return $this->hasMany(detail_transaksi::class, 'transaksi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(metode_pembayaran::class);
    }

}
