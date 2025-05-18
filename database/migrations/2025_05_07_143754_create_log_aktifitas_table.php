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
        Schema::create('log_aktifitas', function (Blueprint $table) {
             $table->uuid('id')->primary(); // UUID, bukan auto-increment
             //relation to users table and delete data in  relation  no action
             $table->uuid('user_id'); // ✅ disamakan dengan UUID
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->string('aktifitas',250);
             $table->string('ip_address',45)->nullable();
             $table->string('user_agent',250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktifitas');
    }
};
