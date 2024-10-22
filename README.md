# To-Do List App

## Pendahuluan

Aplikasi **To-Do List** ini adalah aplikasi sederhana yang memungkinkan pengguna untuk menambah, mengubah, menghapus, dan menampilkan daftar tugas (to-do). Aplikasi ini dibuat menggunakan **Laravel Framework** dan didukung oleh **Bootstrap 5** untuk tampilan yang responsif dan mudah digunakan.

### Fitur Utama:

-   **Menambah tugas baru**: Pengguna dapat menambahkan tugas baru ke dalam daftar.
-   **Mengedit tugas**: Pengguna dapat memperbarui tugas yang sudah ada.
-   **Menandai tugas sebagai selesai atau belum selesai**: Pengguna dapat menandai tugas apakah sudah selesai atau belum.
-   **Menghapus tugas**: Pengguna dapat menghapus tugas dari daftar.
-   **Pencarian tugas**: Pengguna dapat mencari tugas berdasarkan kata kunci tertentu.

---

## Alur Pembuatan Aplikasi

### 1. **Menyiapkan Proyek Laravel**

-   Pertama, buat proyek baru menggunakan Laravel dengan perintah:
    ```bash
    laravel new todo-list
    ```
-   Instal dependensi Laravel yang diperlukan dengan:
    ```bash
    composer install
    ```

### 2. **Membuat Database dan Konfigurasi**

-   Buat database di MySQL untuk menyimpan data to-do list, misalnya `todo_list_db`.
-   Konfigurasikan koneksi database di file `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=todo_list_db
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

### 3. **Membuat Migration untuk Tabel `todo`**

-   Laravel menyediakan fitur migration untuk membuat struktur tabel database. Kami akan membuat tabel `todo` menggunakan migration.
-   Jalankan perintah berikut untuk membuat migration:
    ```bash
    php artisan make:migration create_todo_table
    ```
-   Kemudian, tambahkan definisi tabel di file migration (`database/migrations/xxxx_create_todo_table.php`):
    ```php
    Schema::create('todo', function (Blueprint $table) {
        $table->id();
        $table->string('task');
        $table->boolean('is_done')->default(false); // Tugas selesai atau belum
        $table->timestamps();
    });
    ```
-   Setelah itu, jalankan migration dengan perintah:
    ```bash
    php artisan migrate
    ```

### 4. **Membuat Model Todo**

-   Model adalah representasi dari tabel dalam database. Kami membuat model `Todo` untuk berinteraksi dengan tabel `todo`.
-   Jalankan perintah berikut untuk membuat model:
    ```bash
    php artisan make:model Todo
    ```
-   Pada model `Todo` (`app/Models/Todo.php`), tambahkan properti yang dapat diisi:

    ```php
    class Todo extends Model
    {
        use HasFactory;

        protected $table = 'todo';
        protected $fillable = ['task', 'is_done']; // Field yang dapat diisi
    }
    ```

### 5. **Membuat Controller Todo**

-   Controller berfungsi untuk menangani logika aplikasi. Kami membuat controller `TodoController` untuk mengelola logika CRUD (Create, Read, Update, Delete) to-do list.
-   Jalankan perintah berikut untuk membuat controller:
    ```bash
    php artisan make:controller TodoController
    ```
-   Berikut adalah struktur controller (`app/Http/Controllers/Todo/TodoController.php`):
    -   **index()**: Menampilkan daftar tugas dan pencarian.
    -   **store()**: Menambahkan tugas baru.
    -   **update()**: Memperbarui tugas yang ada.
    -   **destroy()**: Menghapus tugas.

Berikut adalah cuplikan kode dari `TodoController`:

```php
public function index(Request $request)
{
    $search = $request->get('search'); // Mendapatkan kata kunci pencarian
    $data = Todo::when($search, function ($query) use ($search) {
        return $query->where('task', 'like', '%' . $search . '%');
    })->orderBy('task', 'asc')->get();

    return view('todolist.app', compact('data', 'search'));
}

public function store(Request $request)
{
    $request->validate([
        'task' => 'required|min:3|max:255',
    ]);

    Todo::create([
        'task' => $request->task,
    ]);

    return redirect()->route('todo')->with('status', 'Tugas berhasil ditambahkan!');
}

public function update(Request $request, string $id)
{
    $request->validate([
        'task' => 'required|min:3|max:255',
    ]);

    $data = [
        'task' => $request->task,
        'is_done' => $request->input('is_done'),
    ];

    Todo::where('id', $id)->update($data);

    return redirect()->route('todo')->with('status', 'Tugas berhasil diupdate!');
}

public function destroy(string $id)
{
    $todo = Todo::findOrFail($id);
    $todo->delete();

    return redirect()->route('todo')->with('status', 'Tugas berhasil dihapus!');
}
```

### 6. **Membuat Rute (Routing)**

-   Di file `routes/web.php`, tambahkan rute untuk menghubungkan permintaan dari browser ke controller:
    ```php
    Route::get('/todo', [TodoController::class, 'index'])->name('todo');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.post');
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
    ```

### 7. **Membuat View**

-   View merupakan halaman HTML yang akan ditampilkan kepada pengguna. Kami menggunakan **Blade Templating** di Laravel untuk membuat halaman.
-   Buat file view `resources/views/todolist/app.blade.php` untuk menampilkan daftar to-do dengan form tambah dan pencarian tugas.

Berikut cuplikan struktur HTML pada view:

```html
<form action="{{ route('todo.post') }}" method="POST">
    @csrf
    <input type="text" name="task" placeholder="Tambah task baru" />
    <button type="submit">Simpan</button>
</form>

<ul>
    @foreach ($data as $item)
    <li>
        {{ $item->task }}
        <form action="{{ route('todo.destroy', $item->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </li>
    @endforeach
</ul>
```

### 8. **Menambahkan Bootstrap**

-   Untuk tampilan yang lebih baik, kami menggunakan **Bootstrap 5**. Tambahkan link ke Bootstrap di bagian `<head>` pada view:
    ```html
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    ```

### 9. **Menjalankan Aplikasi**

-   Jalankan server pengembangan Laravel menggunakan perintah:
    ```bash
    php artisan serve
    ```
-   Akses aplikasi di browser melalui `http://localhost:8000/todo`.

---

## Penggunaan

1. **Menambahkan Tugas Baru**: Isi form di halaman utama dan klik "Simpan" untuk menambahkan tugas baru.
2. **Mengedit Tugas**: Klik tombol edit di sebelah tugas untuk mengubah isi tugas.
3. **Menghapus Tugas**: Klik tombol hapus (✕) untuk menghapus tugas.
4. **Pencarian**: Masukkan kata kunci di form pencarian untuk menemukan tugas tertentu.

---

## Teknologi yang Digunakan

-   **Laravel 10**
-   **PHP 8.x**
-   **MySQL** sebagai database
-   **Bootstrap 5** untuk desain antarmuka

---

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
