# Sistem Informasi Manajemen Data Katalog Buku

Sistem Informasi Manajemen Data Sederhana berbasis **PHP Native** dan **MySQL/MariaDB** yang dilengkapi dengan otentikasi session, dukungan dual bahasa (Indonesia & English), pengelolaan data CRUD, serta fitur reset password terenkripsi.

## Spesifikasi & Fitur Utama

1. **Sistem Otentikasi & Session**:

   * Proteksi halaman CRUD dari akses langsung tanpa otentikasi login.

   * Penanganan kata sandi menggunakan hash BCRYPT via `password_hash()`.

2. **Dual Bahasa (Multi-Language)**:

   * Dukungan bahasa antarmuka **Bahasa Indonesia (ID)** dan **Bahasa Inggris (EN)**.

   * Pilihan bahasa tersimpan di `$_SESSION` sehingga konsisten saat berpindah halaman.

3. **Pengolahan Form Data & Validasi Security**:

   * Metode pengiriman form menggunakan `POST`.

   * Sanitasi data input menggunakan `htmlspecialchars()` dan `filter_var()` untuk mencegah serangan XSS dan SQL Injection.

   * Penggunaan *Prepared Statement* (`mysqli_prepare`) pada seluruh operasi database.

4. **Operasi CRUD (Create, Read, Update, Delete)**:

   * **Create**: Menambahkan data buku baru ke dalam database.

   * **Read**: Menampilkan seluruh katalog buku dalam tabel HTML yang rapi dan responsif.

   * **Update**: Mengubah data buku berdasarkan ID unik.

   * **Delete**: Menghapus data buku dengan dialog konfirmasi.

5. **Fitur Reset Password (Lupa Kata Sandi)**:

   * Pemulihan kata sandi menggunakan verifikasi **Secret Key** dan enkripsi BCRYPT.

## Kredensial & Secret Key Default

Gunakan informasi berikut untuk pengujian aplikasi:

* **Default Username**: `admin`

* **Default Password**: `admin123`

* **Secret Reset Key (Lupa Password)**: `KATALOG-ADMIN-2026`

## Struktur Folder Proyek

```
katalog-buku/
├── assets/
│   └── style.css          # File CSS styling tampilan (Purple Modern Theme)
├── config/
│   └── database.php       # Konfigurasi koneksi MySQL
├── lang/
│   ├── id.php             # Kamus terjemahan Bahasa Indonesia
│   └── en.php             # Kamus terjemahan Bahasa Inggris
├── database.sql           # Skrip ekspor database MySQL
├── session_init.php       # Inisialisasi session, penanganan bahasa, & fungsi sanitasi
├── index.php              # Halaman Utama / Read Data Katalog
├── login.php              # Halaman Form Login
├── logout.php             # Handling Logout & Destroy Session
├── lupa_password.php      # Form Reset Password dengan Secret Key
├── tambah.php             # Form Tambah Data Buku (Create)
├── edit.php               # Form Ubah Data Buku (Update)
├── hapus.php              # Handling Hapus Data Buku (Delete)
└── README.md              # Dokumentasi proyek

```

## Langkah Instalasi & Penggunaan

1. **Clone / Download Repository**:
   Unduh atau clone repository ini ke dalam direktori server lokal Anda (contoh: `htdocs/katalog-buku` untuk XAMPP).

2. **Impor Database**:

   * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).

   * Buat database baru bernama `db_katalog` (atau biarkan otomatis terbuat dari skrip SQL).

   * Impor file `database.sql` yang berada di dalam folder proyek.

3. **Konfigurasi Database** *(Opsional)*:
   Jika username/password MySQL Anda berbeda, sesuaikan pengaturan pada file `config/database.php`:

   ```
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "db_katalog";
   
   ```

4. **Jalankan Aplikasi**:
   Buka browser dan akses halaman login melalui URL:

   ```
   http://localhost/katalog-buku/login.php
   
   ```

## 📜 Lisensi & Pengumpulan Tugas

Proyek ini disusun untuk memenuhi **Tugas 2 - Membuat Sistem Informasi Manajemen Data Sederhana**.
