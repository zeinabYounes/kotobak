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
        Schema::create('books', function (Blueprint $table) {
          $table->id();
          $table->string('title');
          $table->string('auther');
          $table->string('b_photo_path', 3000)->nullable();
          $table->integer('copies_all');
          $table->integer('copies_borrowed');
          $table->string('edition')->nullable();
          $table->string('genre')->nullable();
          $table->string('ISBN',100)->unique();
          $table->year('published_year')->nullable();
          $table->foreignId('section_id')->nullable();
          $table->foreignId('shelf_id')->nullable();
          $table->tinyInteger('allowed_days')->default(15);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
