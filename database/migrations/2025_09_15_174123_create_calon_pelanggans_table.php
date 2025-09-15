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
        Schema::create('calon_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('password'); // password yang diinginkan user
            $table->foreignId('tarif_id')
                ->default(1)
                ->constrained('tarifs')
                ->onDelete('cascade');
            $table->string('ktp_path')->nullable(); // path file KTP
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable(); // keterangan jika ditolak
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_pelanggans');
    }
};
