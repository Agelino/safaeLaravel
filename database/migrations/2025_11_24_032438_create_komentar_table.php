<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();

            // ✅ ID user pemilik komentar
            $table->unsignedBigInteger('user_id');
            $table->string('username');
            $table->text('komentar');
            $table->string('image_path')->nullable();
            $table->timestamps();

            // (opsional tapi disarankan) relasi ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};
