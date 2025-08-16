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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemakaian_id')
                  ->constrained('pemakaians') // harus sama dengan nama tabel pemakaians
                  ->cascadeOnDelete();
            $table->foreignId('periode_id')
                  ->constrained('periodes') // pastikan tabel periodes ada
                  ->cascadeOnDelete();
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('jumlah_bayar', 12, 2)->nullable();
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
