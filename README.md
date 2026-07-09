<div align="center">

# 📦 Stockify

**Sistem Manajemen Stok Gudang berbasis Web**

Aplikasi web untuk mendigitalisasi pencatatan stok gudang, alur transaksi barang masuk/keluar, dan pelaporan — dengan kontrol akses berbasis peran (role-based access control).

![Status](https://img.shields.io/badge/status-selesai-brightgreen)
![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?logo=mysql)
![License](https://img.shields.io/badge/license-Academic-blue)

</div>

<!-- 🖼️ PLACEHOLDER: Tambahkan screenshot utama / banner aplikasi di sini -->
<!-- ![Stockify Banner](docs/images/banner.png) -->

---

## 📖 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Tujuan Sistem](#-tujuan-sistem)
- [Fitur Utama](#-fitur-utama)
- [Role Pengguna & Hak Akses](#-role-pengguna--hak-akses)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Arsitektur & Pendekatan Pengembangan](#-arsitektur--pendekatan-pengembangan)
- [Struktur Proyek](#-struktur-proyek)
- [Skema Database](#-skema-database)
- [Kebutuhan Sistem](#-kebutuhan-sistem)
- [Instalasi & Konfigurasi](#-instalasi--konfigurasi)
- [Alur Bisnis Utama](#-alur-bisnis-utama)
- [Pengujian](#-pengujian)
- [Roadmap Pengembangan](#-roadmap-pengembangan)
- [Potensi Pengembangan Lanjutan](#-potensi-pengembangan-lanjutan)
- [Kontributor](#-kontributor)

---

## 🧾 Tentang Project

**Stockify** adalah aplikasi web manajemen stok gudang yang dikembangkan untuk menggantikan pencatatan manual yang rentan terhadap kesalahan manusia, tidak efisien, dan sulit diaudit. Seiring pertumbuhan volume barang dalam sebuah gudang, dibutuhkan sistem digital yang mampu merekam setiap pergerakan barang secara akurat, mendukung pengambilan keputusan berbasis data, dan memisahkan tanggung jawab operasional antar pengguna berdasarkan perannya masing-masing.

Aplikasi ini mencakup tiga modul utama:

| Modul | Cakupan |
|---|---|
| **Manajemen Data Master** | Kategori, supplier, produk, dan pengguna |
| **Manajemen Transaksi Stok** | Barang masuk dan keluar dengan alur konfirmasi multi-role |
| **Pelaporan & Analitik** | Laporan stok dan transaksi dengan fitur ekspor PDF |

Stockify dirancang untuk diakses melalui browser web desktop.

<!-- 🖼️ PLACEHOLDER: Tambahkan screenshot dashboard admin di sini -->
<!-- ![Dashboard Admin](docs/images/dashboard-admin.png) -->

---

## 🎯 Tujuan Sistem

- Menyediakan sistem pencatatan stok barang yang akurat dan terintegrasi.
- Mendigitalisasi alur kerja transaksi masuk dan keluar barang gudang.
- Memisahkan hak akses dan tanggung jawab berdasarkan peran pengguna (*role-based access*).
- Menyediakan laporan stok dan transaksi yang dapat diekspor dalam format PDF.
- Memberikan dashboard informatif untuk setiap peran pengguna.

---

## ✨ Fitur Utama

- 🔐 **Autentikasi & Otorisasi** — Login berbasis session Laravel dengan middleware role-based di setiap route.
- 📊 **Dashboard per Role** — Ringkasan data, grafik distribusi produk, dan aktivitas transaksi terbaru yang disesuaikan untuk masing-masing peran.
- 🗂️ **Manajemen Data Master** — CRUD kategori, supplier, produk (lengkap dengan gambar, SKU, harga, stok minimum), dan pengguna.
- 🔄 **Alur Transaksi Multi-Role** — Staff mengajukan transaksi masuk/keluar → Manajer mengonfirmasi/menolak → stok diperbarui otomatis.
- 📦 **Kalkulasi Stok Dinamis** — Stok dihitung secara agregasi dari riwayat transaksi (bukan kolom statis), menjamin konsistensi data.
- 🧮 **Validasi Stok Real-time** — Produk dengan stok habis otomatis dinonaktifkan pada form transaksi keluar.
- 🕓 **Riwayat Transaksi** — Filter multi-kriteria berdasarkan tipe, status, produk, dan rentang tanggal.
- 📄 **Laporan & Ekspor PDF** — Laporan stok dan transaksi dengan filter lengkap dan ekspor ke PDF landscape A4 menggunakan DomPDF.
- 🎨 **UI Responsif** — Dibangun dengan Tailwind CSS dan komponen Flowbite (modal, tabel, dropdown).
- 🇮🇩 **Lokalisasi Bahasa Indonesia** — Format tanggal (Carbon locale `id`) dan format harga Rupiah.

<!-- 🖼️ PLACEHOLDER: Tambahkan screenshot fitur transaksi / laporan di sini -->
<!-- ![Fitur Transaksi](docs/images/fitur-transaksi.png) -->

---

## 👥 Role Pengguna & Hak Akses

| Role | Deskripsi | Level Akses |
|---|---|---|
| **Admin** | Pengelola sistem secara keseluruhan, bertanggung jawab atas data master dan konfigurasi pengguna. | Penuh (*Full Access*) |
| **Manajer Gudang** | Mengawasi operasional gudang, mengonfirmasi/menolak transaksi stok, memantau kondisi stok. | Operasional + Read-only Master Data |
| **Staff Gudang** | Pelaksana harian yang menginput transaksi barang masuk/keluar dan memantau pengajuan miliknya. | Input Transaksi |

### Detail Hak Akses

<details>
<summary><strong>🛠️ Admin</strong></summary>

- Autentikasi (login/logout).
- Dashboard: total produk, transaksi masuk/keluar bulan ini, stok menipis, grafik distribusi produk per kategori, aktivitas terbaru.
- Manajemen Kategori (CRUD penuh).
- Manajemen Supplier (CRUD penuh).
- Manajemen Produk (CRUD penuh, termasuk gambar, harga, SKU, stok minimum, atribut inline).
- Manajemen Pengguna (buat akun, edit data/role, reset password, hapus pengguna kecuali akun sendiri).
- Riwayat Transaksi (filter tipe, status, produk, rentang tanggal).
- Laporan Stok & Laporan Transaksi (dengan ekspor PDF).

</details>

<details>
<summary><strong>📋 Manajer Gudang</strong></summary>

- Autentikasi (login/logout).
- Dashboard: transaksi pending, barang masuk/keluar hari ini, daftar pending, produk stok menipis.
- Daftar & Detail Produk (*read-only*, tanpa Edit/Hapus).
- Daftar Supplier (*read-only*).
- Konfirmasi Transaksi Masuk (terima → stok bertambah, tolak → stok tidak berubah).
- Konfirmasi Transaksi Keluar (validasi stok otomatis, tombol nonaktif jika stok tidak cukup).
- Riwayat Transaksi (filter lengkap).
- Laporan Stok & Laporan Transaksi (dengan ekspor PDF).

</details>

<details>
<summary><strong>📥 Staff Gudang</strong></summary>

- Autentikasi (login/logout).
- Dashboard: total pengajuan pribadi, transaksi pending, transaksi diproses hari ini, riwayat 8 transaksi terakhir.
- Input Transaksi Masuk (status awal otomatis *Pending*).
- Riwayat Transaksi Masuk (status semua pengajuan).
- Input Transaksi Keluar (validasi stok real-time, produk stok 0 dinonaktifkan).
- Riwayat Transaksi Keluar (status semua pengajuan).

</details>

<!-- 🖼️ PLACEHOLDER: Tambahkan screenshot perbandingan dashboard per role di sini -->
<!-- ![Perbandingan Dashboard Role](docs/images/dashboard-per-role.png) -->

---

## 🧰 Teknologi yang Digunakan

| Layer | Teknologi | Versi | Fungsi |
|---|---|---|---|
| Backend Framework | Laravel | 10.x | Routing, ORM, middleware, validasi, session |
| Bahasa Pemrograman | PHP | 8.2+ | Logika server-side aplikasi |
| Database | MySQL | 8.x | Penyimpanan data relasional (pendekatan database-first) |
| Frontend Styling | Tailwind CSS | 3.4.17 | Utility-first CSS framework |
| UI Components | Flowbite | Latest | Komponen berbasis Tailwind (modal, tabel, dropdown) |
| Build Tool | Vite | Latest | Bundler aset frontend (JS, CSS) |
| PDF Export | DomPDF (barryvdh) | Latest | Generate PDF dari Blade view sisi server |
| Design Tool | MySQL Workbench | Latest | Desain skema database (EER Diagram) |
| Version Control | Git + GitHub | — | Pengelolaan versi kode sumber |
| IDE | VS Code | — | Editor kode dengan ekstensi PHP Intelephense |

---

## 🏗️ Arsitektur & Pendekatan Pengembangan

### Controller-Service-Repository (CSR)

Stockify menerapkan pola arsitektur **Controller-Service-Repository** yang memisahkan tanggung jawab tiap layer secara tegas:

| Layer | Lokasi | Tanggung Jawab |
|---|---|---|
| Controller | `app/Http/Controllers/{Role}/` | Menerima HTTP request, memanggil Service, mengembalikan response. Tidak berisi logika bisnis/query. |
| Service | `app/Services/` | Seluruh logika bisnis. Memanggil Repository, dapat dipakai lintas Controller. |
| Repository Interface | `app/Repositories/Interfaces/` | Kontrak method tanpa implementasi. |
| Eloquent Repository | `app/Repositories/Eloquent/` | Implementasi konkret Interface menggunakan Eloquent ORM. |
| Model | `app/Models/` | Representasi tabel database & relasi antar tabel. |
| View | `resources/views/` | Template Blade, dipisah per role dan fitur. |

**Alur request:**

```
HTTP Request → Route → Middleware → Controller → Service → Repository Interface → Eloquent Repository → Database → View
```

**Alasan pemilihan arsitektur CSR:**
- **Separation of Concerns** — setiap layer memiliki satu tanggung jawab jelas.
- **Reusabilitas** — Service dapat dipakai beberapa Controller (mis. `ProductService` dipakai `Admin\ProductController` & `Manager\ProductController`).
- **Testability** — Repository dapat di-*mock* saat unit testing berkat pola Interface.
- **Fleksibilitas** — penggantian implementasi database cukup dilakukan di layer Repository.

### Pendekatan Database-First

Skema database dirancang lebih dulu menggunakan **MySQL Workbench** sebelum kode aplikasi ditulis. Perubahan skema dilakukan di Workbench lalu disinkronkan ke database, **bukan** menggunakan Laravel Migration.

> ⚠️ **Catatan penting bagi developer:** Karena project ini *database-first*, jangan menjalankan `php artisan migrate` untuk membuat ulang skema. Struktur tabel harus disiapkan langsung melalui MySQL Workbench atau file SQL dump (lihat bagian [Instalasi & Konfigurasi](#-instalasi--konfigurasi)).

### Pendekatan Kalkulasi Stok (Pendekatan B)

Stok **tidak** disimpan sebagai kolom statis di tabel `products`, melainkan dihitung secara dinamis dari tabel `stock_transactions`:

```
Stok Aktual = Σ(quantity WHERE type='Masuk' AND status='Diterima')
            − Σ(quantity WHERE type='Keluar' AND status='Dikeluarkan')
```

Untuk efisiensi, `StockService::getStockMap()` hanya membutuhkan **2 query** untuk menghitung stok seluruh produk sekaligus (satu untuk transaksi masuk, satu untuk transaksi keluar), menghasilkan array `[product_id => stok_aktual]`.

### Prinsip Pengembangan

- **DRY** — partial Blade & shared Service/Repository antar Controller berbeda role.
- **Feature-first** — satu fitur selesai 100% sebelum berpindah ke fitur berikutnya.
- **Database-first** — skema database selesai sebelum kode ditulis.
- **Role isolation** — Controller, View, dan Route dipisah per role.

<!-- 🖼️ PLACEHOLDER: Tambahkan diagram arsitektur CSR di sini -->
<!-- ![Diagram Arsitektur CSR](docs/images/arsitektur-csr.png) -->

---

## 📁 Struktur Proyek

```
stockify/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/
│   │       ├── Manager/
│   │       └── Staff/
│   ├── Services/
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   └── Eloquent/
│   ├── Models/
│   └── Http/Middleware/
├── resources/
│   └── views/
│       ├── admin/
│       ├── manager/
│       ├── staff/
│       └── layouts/
├── routes/
│   └── web.php
├── database/
│   └── (skema dikelola via MySQL Workbench, lihat catatan database-first)
├── public/
└── .env.example
```

> Struktur di atas mengikuti pola default Laravel dengan pemisahan direktori Controller dan View per role (`Admin`, `Manager`, `Staff`) sesuai prinsip *role isolation*.

### Route Structure

| Prefix | Middleware | Contoh Route |
|---|---|---|
| `/login`, `/logout` | `guest` / `auth` | `GET /login`, `POST /login`, `POST /logout` |
| `/admin/*` | `auth`, `role:Admin` | `GET /admin/dashboard`, resource `/admin/categories`, `/admin/suppliers`, `/admin/products`, `/admin/users`, `GET /admin/laporan/stok`, `GET /admin/laporan/transaksi` |
| `/manager/*` | `auth`, `role:Manajer Gudang` | `GET /manager/dashboard`, `GET /manager/products`, `GET /manager/suppliers`, `GET /manager/transaksi-masuk`, `POST /manager/transaksi-masuk/{id}/konfirmasi`, `GET /manager/laporan/stok` |
| `/staff/*` | `auth`, `role:Staff Gudang` | `GET /staff/dashboard`, `GET/POST /staff/transaksi-masuk`, `GET/POST /staff/transaksi-keluar` |

---

## 🗄️ Skema Database

Stockify menggunakan pendekatan relasional dengan foreign key constraint di seluruh relasi tabel.

| Tabel | Kolom Utama | Relasi |
|---|---|---|
| `users` | `id`, `name`, `email`, `password`, `role` (ENUM) | Memiliki banyak `stock_transactions` |
| `categories` | `id`, `name`, `description`, `created_at`, `updated_at` | Memiliki banyak `products` |
| `suppliers` | `id`, `name`, `address`, `phone`, `email`, `created_at`, `updated_at` | Memiliki banyak `products` |
| `products` | `id`, `category_id`, `supplier_id`, `name`, `sku`, `description`, `purchase_price`, `selling_price`, `image`, `minimum_stock`, `created_at`, `updated_at` | Belongs to `categories` & `suppliers`; memiliki banyak `product_attributes` & `stock_transactions` |
| `product_attributes` | `id`, `product_id`, `name`, `value` | Belongs to `products` |
| `stock_transactions` | `id`, `product_id`, `user_id`, `type` (ENUM), `quantity`, `date`, `status` (ENUM), `notes`, `created_at`, `updated_at` | Belongs to `products` & `users` |

### Nilai ENUM Penting

| Tabel.Kolom | Nilai ENUM |
|---|---|
| `users.role` | `Admin` \| `Manajer Gudang` \| `Staff Gudang` |
| `stock_transactions.type` | `Masuk` \| `Keluar` |
| `stock_transactions.status` | `Pending` \| `Diterima` \| `Ditolak` \| `Dikeluarkan` |

<!-- 🖼️ PLACEHOLDER: Tambahkan ERD (Entity Relationship Diagram) di sini -->
<!-- ![ERD Stockify](docs/images/erd-database.png) -->

---

## 💻 Kebutuhan Sistem

### Aspek Non-Fungsional

| Aspek | Ketentuan |
|---|---|
| **Keamanan** | Autentikasi berbasis session Laravel, role-based middleware di setiap route, validasi CSRF pada seluruh form, password di-hash dengan bcrypt. |
| **Performa** | Kalkulasi stok via agregasi tabel transaksi dengan query efisien (`getStockMap()`, 2 query untuk semua produk). |
| **Usability** | UI responsif (Tailwind CSS), modal konfirmasi untuk aksi destruktif, flash message tiap aksi, active state pada sidebar. |
| **Maintainability** | Arsitektur CSR, interface-based repository. |
| **Konsistensi Data** | Foreign key constraint, ENUM untuk kolom bertipe terbatas, validasi server-side. |
| **Format** | Tanggal Bahasa Indonesia (Carbon locale `id`), harga dalam format Rupiah. |
| **Ekspor** | Laporan diekspor ke PDF (DomPDF) dengan layout landscape A4. |

### Software yang Dibutuhkan

- PHP **8.2** atau lebih tinggi
- Composer
- Node.js & NPM (untuk build asset via Vite)
- MySQL **8.x**
- MySQL Workbench (untuk mengelola skema database)
- Git

---

## ⚙️ Instalasi & Konfigurasi

> ⚠️ Karena Stockify menggunakan pendekatan **database-first**, pastikan skema database sudah tersedia (misalnya via file `.sql` dump atau MySQL Workbench) sebelum menjalankan aplikasi — jangan mengandalkan `php artisan migrate`.

### 1. Clone Repository

```bash
git clone https://github.com/username/stockify.git
cd stockify
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stockify
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Siapkan Database

Import skema database (hasil desain MySQL Workbench) ke MySQL:

```bash
mysql -u root -p stockify < database/stockify_schema.sql
```

> 📌 Pastikan kolom `id` pada seluruh tabel sudah diset **AUTO_INCREMENT**, dan kolom `created_at`/`updated_at` tersedia di setiap tabel (lihat bagian [Isu yang Ditemukan](#-pengujian) untuk detail).

### 5. Seed Data Awal (opsional)

```bash
php artisan db:seed --class=UserSeeder
```

### 6. Build Asset Frontend

```bash
npm run build
# atau untuk mode development:
npm run dev
```

### 7. Jalankan Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui `http://127.0.0.1:8000`.

<!-- 🖼️ PLACEHOLDER: Tambahkan screenshot halaman login di sini -->
<!-- ![Halaman Login](docs/images/login.png) -->

---

## 🔁 Alur Bisnis Utama

### Transaksi Barang Masuk

1. Staff Gudang login dan mengisi form transaksi masuk (produk, jumlah, tanggal, catatan). Status awal: **Pending**.
2. Manajer Gudang membuka daftar transaksi pending dan memilih **Terima** atau **Tolak**.
3. Jika diterima → status menjadi **Diterima**, stok otomatis bertambah.
4. Jika ditolak → status menjadi **Ditolak**, stok tidak berubah.
5. Staff dapat memantau status melalui riwayat/dashboard pribadi.

### Transaksi Barang Keluar

1. Staff mengisi form transaksi keluar (produk dengan stok 0 dinonaktifkan di dropdown).
2. Sistem memvalidasi stok sebelum menyimpan — jika melebihi stok tersedia, transaksi ditolak dengan flash error.
3. Jika valid, transaksi tersimpan dengan status **Pending**.
4. Manajer melakukan validasi ulang saat konfirmasi (tombol otomatis nonaktif jika stok tidak cukup).
5. Jika dikonfirmasi → status **Dikeluarkan**, stok otomatis berkurang.

### Manajemen Data Master

Urutan pembuatan data master: **Kategori → Supplier → Produk → Pengguna** (karena produk bergantung pada kategori & supplier).

### Pelaporan

Admin/Manajer dapat memfilter laporan stok/transaksi (kategori, tipe, status, produk, rentang tanggal) lalu mengekspornya ke PDF landscape A4.

<!-- 🖼️ PLACEHOLDER: Tambahkan diagram alur transaksi (flowchart) di sini -->
<!-- ![Alur Transaksi Barang Masuk](docs/images/alur-transaksi-masuk.png) -->

---

## 🧪 Pengujian

Pengujian dilakukan secara manual menggunakan **Blackbox Testing** dan **Functional Testing**, mencakup skenario positif (input valid) dan negatif (input tidak valid, akses tidak berwenang).

| Kategori | Jumlah Test Case | Hasil |
|---|---|---|
| Autentikasi & Otorisasi (AUTH) | 9 | ✅ Semua Lulus |
| Master Data — Kategori (KAT) | 6 | ✅ Semua Lulus |
| Master Data — Supplier (SUP) | 7 | ✅ Semua Lulus |
| Master Data — Produk (PRD) | 13 | ✅ Semua Lulus |
| Manajemen Pengguna (USR) | 8 | ✅ Semua Lulus |
| Transaksi Masuk (TRM) | 8 | ✅ Semua Lulus |
| Transaksi Keluar (TRK) | 7 | ✅ Semua Lulus |
| Riwayat Transaksi (RWT) | 7 | ✅ Semua Lulus |
| Dashboard (DSH) | 7 | ✅ Semua Lulus |
| **Total** | **72** | ✅ **72/72 Lulus (100%)** |

### Beberapa Isu yang Ditemukan & Solusinya

| Isu | Penyebab | Solusi |
|---|---|---|
| `SQLSTATE`: Column not found `created_at` | Tabel tidak memiliki kolom timestamp karena pendekatan database-first tanpa migration | Menambahkan kolom `created_at`/`updated_at` via `ALTER TABLE` di MySQL Workbench |
| Nilai ENUM tidak cocok (`'pending'` vs `'Pending'`) | Nilai ENUM di database huruf kecil, kode menggunakan huruf kapital | Menyeragamkan ENUM ke huruf kapital + update data existing |
| Kolom `id` tidak AUTO_INCREMENT | Saat sync Workbench, flag AI belum diset | Mengaktifkan flag AI pada kolom `id` semua tabel via Table Editor |
| Transaksi keluar tidak muncul di riwayat Staff | Filter query di Controller salah tempat (harusnya di Repository) | Memindahkan implementasi ke Eloquent Repository + update Interface |

---

## 🗺️ Roadmap Pengembangan

Pengembangan dilakukan secara iteratif *feature-by-feature*, dengan total **20 phase** yang seluruhnya telah selesai (✅):

| Phase | Nama | Status |
|---|---|---|
| Phase 0 | Project Foundation | ✅ Selesai |
| Phase 1 | Authentication & Role System | ✅ Selesai |
| Phase 2A | Base Layout & Sidebar | ✅ Selesai |
| Phase 2B | CRUD Kategori | ✅ Selesai |
| Phase 2C | CRUD Supplier | ✅ Selesai |
| Phase 2D | CRUD Produk | ✅ Selesai |
| Phase 2E | Atribut Produk | ✅ Selesai |
| Phase 2F | Manajemen Pengguna | ✅ Selesai |
| Phase 2G | Admin Dashboard | ✅ Selesai |
| Phase 3A | Stock Tracking Setup | ✅ Selesai |
| Phase 3B | Transaksi Masuk — Staff | ✅ Selesai |
| Phase 3C | Transaksi Masuk — Manajer | ✅ Selesai |
| Phase 3D | Transaksi Keluar — Staff | ✅ Selesai |
| Phase 3E | Transaksi Keluar — Manajer | ✅ Selesai |
| Phase 3F | Riwayat Transaksi | ✅ Selesai |
| Phase 3G | Update Dashboard | ✅ Selesai |
| Phase 4A | Laporan Stok | ✅ Selesai |
| Phase 4B | Laporan Transaksi | ✅ Selesai |
| Phase 4C | Finalisasi (halaman error, locale) | ✅ Selesai |

---

## 🚀 Potensi Pengembangan Lanjutan

- 🔔 Notifikasi real-time (Laravel Echo + Pusher) untuk alert stok menipis.
- 📏 Fitur *stock opname* (penghitungan fisik stok) untuk rekonsiliasi stok sistem vs aktual.
- 📊 Export laporan ke format Excel (package Maatwebsite Excel).
- 🔌 API RESTful untuk integrasi sistem eksternal/aplikasi mobile.
- 📝 Audit log untuk merekam setiap perubahan data.
- 🏬 Dukungan multi-gudang untuk perusahaan dengan lebih dari satu lokasi.

---

## 👤 Kontributor

Dikembangkan oleh **Muhamad Dzakwan Alfaris** — NIM 234311019
Program Studi Teknologi Rekayasa Perangkat Lunak, Politeknik Negeri Madiun (2026)

---

<div align="center">

*Dokumen ini merupakan ringkasan teknis dari dokumentasi resmi aplikasi Stockify versi 1.0.*

</div>
