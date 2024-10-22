<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Menggunakan class anonymous untuk mendefinisikan migrasi
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat tabel 'todo'
        Schema::create('todo', function (Blueprint $table) {
            $table->id(); // Menambahkan kolom 'id' yang bertipe bigint dan auto-increment
            $table->string('task'); // Menambahkan kolom 'task' bertipe string untuk menyimpan deskripsi tugas
            $table->boolean('is_done')->default(false); // Menambahkan kolom 'is_done' bertipe boolean, default-nya false
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at' secara otomatis
    
            // Jika Anda ingin membuat satu kolom timestamp saja, namai seperti ini:
            // $table->timestamp('your_column_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'todo' jika migrasi dibatalkan
        Schema::dropIfExists('todo');
    }
};