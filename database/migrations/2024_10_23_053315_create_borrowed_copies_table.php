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
        Schema::create('borrowed_copies', function (Blueprint $table) {
          $table->id();
          $table->foreignId('book_id')->nullable();
          $table->foreignId('user_id')->nullable();//reader
          $table->enum('status', ['borrowed', 'returned'])->default('borrowed');

          $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_copies');
    }
};
