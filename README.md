# 📰 Ayo Behacaar — Platform Portal Artikel Modern

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red.svg?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue.svg?style=flat-square&logo=php)](https://php.net)
[![Livewire Version](https://img.shields.io/badge/Livewire-4.x-pink.svg?style=flat-square&logo=livewire)](https://livewire.laravel.com)
[![Vite](https://img.shields.io/badge/Vite-8.x-purple.svg?style=flat-square&logo=vite)](https://vitejs.dev)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x_/_4.x-38B2AC.svg?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![QA Tests](https://img.shields.io/badge/Tests-131%20Passed-brightgreen.svg?style=flat-square&logo=phpunit)](https://phpunit.de)

**Ayo Behacaar** adalah platform portal artikel dan literasi digital modern yang dirancang secara estetis dan berkinerja tinggi. Berakar dari semangat nilai-nilai luhur budaya Kalimantan, khususnya Tunjung Dayak (di mana *"Behacaar"* melambangkan semangat belajar dan menuntut ilmu), platform ini dirancang untuk menyajikan konten berkualitas secara inklusif kepada masyarakat luas.

Aplikasi ini dibangun untuk memenuhi tugas **Praktikum Pemrograman Berbasis Web** dengan standar industri modern, arsitektur bersih, serta kualitas penjaminan mutu (QA) yang sangat tinggi.

---

## 🚀 Fitur Utama

### 1. Portal Publik (Guest View)
*   **Homepage Dinamis**: Menampilkan slider artikel unggulan, daftar kategori populer, dan artikel-artikel edukasi terbaru.
*   **Halaman About**: Menjelaskan visi, misi, filosofi kebudayaan, serta komitmen editorial portal.
*   **Portal Artikel Lengkap**:
    *   Sistem pencarian (*Search*) artikel cepat berdasarkan judul maupun konten.
    *   Penyaringan (*Filter*) artikel berdasarkan kategori.
    *   Detail artikel interaktif dilengkapi dengan konversi Markdown otomatis yang bersih dan rapi.
    *   Sistem artikel terkait (*Related Articles*) berdasarkan kesamaan kategori.
    *   Penghitung jumlah pembaca (*Views Counter*) otomatis.
    *   Sistem pagination yang responsif.
*   **Portal Kategori**: Menampilkan kartu kategori dengan visual menarik serta jumlah artikel aktif di setiap kategori.

### 2. Panel Admin (Dashboard Administrator)
*   **Halaman Dashboard**: Menyajikan ringkasan statistik (total artikel, total kategori, total views), artikel terpopuler, serta aktivitas penulisan terbaru.
*   **Livewire CRUD Kategori**: Pengelolaan kategori artikel lengkap dengan pembuat tautan ramah SEO (*Auto Slug Generator*) dan validasi lengkap.
*   **Livewire CRUD Artikel**: Editor penulisan artikel canggih yang mendukung markup Markdown, validasi duplikasi judul, dan pengaturan status publikasi.
*   **Livewire Settings Website**: Pengaturan dinamis identitas website (Nama Situs, Tagline, Deskripsi SEO, Email Kontak, Sosial Media) langsung dari halaman admin.

### 3. Keamanan & Autentikasi (Laravel Breeze)
*   Sistem Login, Registrasi, Lupa Kata Sandi, dan Reset Kata Sandi.
*   Perlindungan jalur admin menggunakan middleware `auth` dan proteksi CSRF.

---

## 🛠️ Tech Stack yang Digunakan

*   **Backend (Core Framework)**: Laravel 13 (PHP 8.3+)
*   **Frontend (Reactivity & Logic)**: Livewire 4 & AlpineJS
*   **Styling & Design System**: Tailwind CSS (Vanilla Modern Responsive Design)
*   **Asset Bundler**: Vite (v8.0)
*   **Database**:
    *   **MySQL** (Lingkungan Produksi / Lokal)
    *   **SQLite** (Lingkungan Pengujian In-Memory)
*   **Testing Engine**: PHPUnit 12.5+ (131 Test Cases - 100% Passed)

---

## 📦 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Prasyarat
Pastikan komputer Anda sudah terinstal:
*   PHP >= 8.3 (dengan ekstensi `pdo_sqlite`, `sqlite3` aktif)
*   Composer
*   Node.js & NPM

### 2. Kloning Repositori & Instal Dependensi
```bash
# Kloning repositori
git clone https://github.com/ahmddanii/ayobehacaarbs.git
cd ayobehacaarbs

# Instal dependensi PHP
composer install

# Instal dependensi Javascript/CSS
npm install
```

### 3. Konfigurasi Environment
```bash
# Salin konfigurasi environment default
copy .env.example .env

# Generate kunci enkripsi aplikasi
php artisan key:generate
```
*Buka file `.env` di text editor Anda dan sesuaikan konfigurasi koneksi database Anda (misal `DB_CONNECTION=mysql` atau `DB_CONNECTION=sqlite`).*

### 4. Jalankan Migrasi & Database Seeder
Untuk membuat tabel dan menginisialisasi akun admin bawaan beserta contoh kategori & artikel:
```bash
php artisan migrate --seed
```
*Akun Administrator Bawaan:*
*   **Email**: `admin@ayobehacaar.com`
*   **Password**: `password` (atau sesuai setelan di seeder Anda)

### 5. Kompilasi Aset & Jalankan Server Lokal
```bash
# Kompilasi aset CSS & JS untuk produksi
npm run build

# Jalankan server Laravel lokal
php artisan serve
```
Aplikasi sekarang dapat diakses melalui browser di alamat **`http://127.0.0.1:8000`**.

---

## 🧪 Pengujian QA (Testing)

Aplikasi ini dilengkapi dengan **131 test cases (285 assertions)** berkualitas tinggi yang menguji performa model, relasi database, otorisasi akses, hingga fungsionalitas Livewire CRUD.

Untuk menjalankan pengujian secara otomatis:
```bash
php artisan test
```

*Seluruh pengujian berjalan secara terisolasi menggunakan database **SQLite in-memory** agar proses pengujian berjalan sangat cepat (~7 detik) tanpa merusak atau mengubah data pada database lokal utama Anda.*

---

## 🧑‍💻 Penulis / Informasi Praktikum

*   **Mata Kuliah**: Praktikum Pemrograman Berbasis Web
*   **Nama Proyek**: Ayo Behacaar
*   **Status**: Siap untuk Pengujian / Deploy (Production Ready)

---

## 📄 Lisensi

Proyek ini dibuat untuk pemenuhan tugas akademik dengan menggunakan basis teknologi open-source **Laravel** yang berlisensi [MIT License](https://opensource.org/licenses/MIT).
