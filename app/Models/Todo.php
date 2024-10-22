<?php

namespace App\Models;

// Menggunakan trait HasFactory untuk mendukung factory
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Menggunakan kelas Model sebagai basis untuk model Eloquent
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    // Menggunakan trait HasFactory untuk menyediakan fitur factory pada model ini
    use HasFactory;

    // Menentukan nama tabel yang digunakan oleh model ini
    protected $table = 'todo';

    // Menentukan field yang dapat diisi secara massal
    protected $fillable = ['task', 'is_done'];
}