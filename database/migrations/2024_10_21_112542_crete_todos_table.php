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
        Schema::create('todo', function (Blueprint $table) {
            $table->id();
            $table->string('task');
            $table->boolean('is_done')->default(false);
            $table->timestamps(); // Use this to create 'created_at' and 'updated_at' timestamps
    
            // If you intended to create a single timestamp column, name it like this:
            // $table->timestamp('your_column_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo');
    }
};