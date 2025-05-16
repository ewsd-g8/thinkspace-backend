<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_idea', function (Blueprint $table) {
            $table->uuid('idea_id');  // Must match type in `ideas` table
            $table->uuid('category_id');  // Must match type in `categories` table

            // Foreign Keys
            $table->foreign('idea_id')->references('id')->on('ideas')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            // Composite Primary Key (prevents duplicate entries)
            $table->primary(['idea_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_idea');
    }
};
