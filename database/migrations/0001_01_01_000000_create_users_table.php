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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username',50);
            $table->string('img',255);
            $table->string('nama_lengkap',199);
            $table->string('email',100)->unique();
            $table->string('password');
            $table->tinyInteger('type')->default(0); // Users: 0=>Kasir, 1=>Admin
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
