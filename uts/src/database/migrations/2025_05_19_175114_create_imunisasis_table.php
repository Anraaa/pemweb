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
        Schema::create('imunisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained(); // Relasi ke pasien
            $table->enum('jenis_vaksin', ['BCG', 'Polio', 'DPT', 'Hepatitis B', 'Campak']);
            $table->date('tanggal');
            $table->enum('status', ['tertunda', 'selesai'])->default('selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imunisasis');
    }
};
