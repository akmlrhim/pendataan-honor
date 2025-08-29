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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kontrak_id')->nullable()->constrained('kontrak')->nullOnDelete();
            $table->foreignId('anggaran_id')->nullable()->constrained('anggaran')->nullOnDelete();
            $table->text('deskripsi_tugas');
            $table->integer('jumlah_dokumen');
            $table->integer('jumlah_target_dokumen');
            $table->string('satuan', 40);
            $table->decimal('harga_satuan', 15, 0);
            $table->decimal('harga_total_tugas', 15, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
