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
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID, bukan auto-increment
            $table->string('barcode',50)->unique();
            $table->string('name',100);
            $table->string('img',250);
            $table->decimal('harga_beli',12,2);
            $table->decimal('harga_jual',12,2);
            $table->string('stock');
            $table->uuid('supliyer_id'); // ✅ disamakan dengan UUID
            $table->foreign('supliyer_id')->references('id')->on('supliyers')->onDelete('cascade');
            $table->uuid('kategori_id'); // ✅ disamakan dengan UUID
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('NO ACTION');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
