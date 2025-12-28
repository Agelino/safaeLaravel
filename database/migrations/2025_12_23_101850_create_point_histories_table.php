<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('points'); 
            $table->timestamps();

            // relasi ke users
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // relasi ke books
            $table->foreign('book_id')
                  ->references('id')->on('books')
                  ->onDelete('cascade');

            // cegah poin dobel untuk buku yang sama
            $table->unique(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_histories');
    }
};
