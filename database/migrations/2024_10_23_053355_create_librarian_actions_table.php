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
        Schema::create('librarian_actions', function (Blueprint $table) {
          $table->id();
          $table->foreignId('request_id')->nullable();
          $table->foreignId('user_id')->nullable();//librarian
          $table->enum('action', ['approved','rejected']);
          $table->timestamp('action_data', precision: 0);
          $table->timestamp('return_data', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('librarian_actions');
    }
};
