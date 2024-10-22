<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua tugas, termasuk fitur pencarian.
     */
    public function index(Request $request)
    {
        // Mendapatkan nilai pencarian dari input
        $search = $request->get('search');

        // Mengambil data berdasarkan pencarian jika ada, jika tidak, ambil semua data
        $data = Todo::when($search, function($query) use ($search) {
            // Menggunakan 'like' untuk mencocokkan kata kunci pada kolom 'task'
            return $query->where('task', 'like', '%' . $search . '%');
        })->orderBy('task', 'asc')->get(); // Mengurutkan data berdasarkan kolom 'task'

        // Mengembalikan view dengan data tugas dan kata kunci pencarian
        return view('todolist.app', compact('data', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat tugas baru (jika diperlukan).
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan tugas baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'task' => 'required|min:3|max:255',
        ],[
            'task.required' => 'Tugas harus diisi',
            'task.min' => 'Tugas minimal 3 karakter',
            'task.max' => 'Tugas maksimal 255 karakter',
        ]);

        // Mengambil data tugas dari input
        $data = [
            'task' => $request->input('task'),
        ];

        // Menyimpan tugas baru ke database
        Todo::create($data);
        
        // Redirect kembali dengan pesan status
        return redirect()->route('todo')->with('status', 'Tugas baru ditambahkan');
    }   

    /**
     * Display the specified resource.
     * Menampilkan detail tugas yang spesifik (jika diperlukan).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit tugas yang sudah ada (jika diperlukan).
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui tugas yang sudah ada di dalam database.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari pengguna
        $request->validate([
            'task' => 'required|min:3|max:255',
        ],[
            'task.required' => 'Tugas harus diisi',
            'task.min' => 'Tugas minimal 3 karakter',
            'task.max' => 'Tugas maksimal 255 karakter',
        ]);

        // Mengambil data dari input untuk diupdate
        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done'),
        ];

        // Mencari tugas berdasarkan ID dan memperbarui datanya
        Todo::where('id', $id)->update($data);

        // Redirect kembali dengan pesan status
        return redirect()->route('todo')->with('status', 'Tugas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus tugas dari database berdasarkan ID yang diberikan.
     */
    public function destroy(string $id)
    {
        // Cari item berdasarkan ID dan hapus
        $todo = Todo::findOrFail($id); // Mencari tugas berdasarkan ID
        $todo->delete(); // Menghapus tugas

        // Redirect dengan pesan sukses
        return redirect('/todo')->with('success', 'Task deleted successfully!');
    }
}


// Penjelasan Tambahan
// Namespace dan Import:

// namespace App\Http\Controllers\Todo;: Menentukan lokasi file ini dalam struktur folder aplikasi.
// use App\Http\Controllers\Controller;: Mengimpor kelas controller dasar dari Laravel.
// use App\Models\Todo;: Mengimpor model Todo yang digunakan untuk berinteraksi dengan tabel todos di database.
// use Illuminate\Http\Request;: Mengimpor kelas Request untuk menangani input dari pengguna.
// Metode CRUD:

// index(): Mengambil dan menampilkan daftar tugas, mendukung fitur pencarian.
// create(): Menampilkan form untuk membuat tugas baru (tidak digunakan dalam kode ini).
// store(): Mengambil input dari pengguna dan menyimpan tugas baru ke database dengan validasi.
// show(): Menampilkan detail tugas tertentu (tidak digunakan dalam kode ini).
// edit(): Menampilkan form untuk mengedit tugas yang sudah ada (tidak digunakan dalam kode ini).
// update(): Memperbarui data tugas yang sudah ada berdasarkan ID dengan validasi.
// destroy(): Menghapus tugas berdasarkan ID yang diberikan dan mengembalikan pesan sukses