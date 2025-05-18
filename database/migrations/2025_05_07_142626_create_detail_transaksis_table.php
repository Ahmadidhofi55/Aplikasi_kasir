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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID, bukan auto-increment
            //realtion to transaksi table on delete otomatis and update
            $table->uuid('transaksi_id');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
            //realtion to produk table on delete no action and update otomatis
            $table->uuid('produk_id'); // ✅ disamakan dengan UUID
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->string('qty');
            $table->decimal('harga',12,2);
            $table->string('jumlah');
            $table->decimal('subtotal',12,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
