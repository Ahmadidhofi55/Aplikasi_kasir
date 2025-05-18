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
        Schema::create('supliyers', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID, bukan auto-increment
            $table->string('name',100);
            $table->text('alamat');
            $table->string('telepon',15);
            $table->string('email',100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supliyers');
    }
};
