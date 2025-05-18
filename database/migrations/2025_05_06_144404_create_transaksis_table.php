<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID, bukan auto-increment
            $table->string('kode_transaksi')->unique(); // Kode transaksi: TX202505130001
            //relation to users table and delete data in  relation  no action
            $table->uuid('user_id'); // ✅ disamakan dengan UUID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('total',12,2);
            $table->decimal('tunai',12,2);
            $table->decimal('kembalian',12,2);
            //relation to metode_pembayaran delete no actin update
            $table->uuid('metode_pembayaran_id'); // ✅ disamakan dengan UUID
            $table->foreign('metode_pembayaran_id')->references('id')->on('metode_pembayarans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
