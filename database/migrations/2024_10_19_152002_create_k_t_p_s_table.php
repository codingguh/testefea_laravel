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
        Schema::create('k_t_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('no_ktp')->unique();
            $table->string('image');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->foreignId('kk_id')->constrained('k_k_s')->onDelete('cascade'); // Relasi ke KK
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_t_p_s');
    }
};
