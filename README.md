# IPWIJA SmartLab - Sistem Informasi Laboratorium

IPWIJA SmartLab adalah Sistem Informasi Laboratorium untuk mengelola inventaris alat, peminjaman barang, serta menyediakan laporan dan audit trail aktivitas. Sistem ini dibangun dengan **Laravel** (Backend/Web) dan menggunakan **n8n** (Webhook Automation) untuk mengirim email notifikasi ke dosen/mahasiswa secara otomatis.

---

## Arsitektur & Lingkungan

- **Web Framework:** Laravel 10/11
- **Database:** MySQL
- **Automation/Webhook:** n8n (Menjalankan email automation)
- **Containerization:** Docker & Docker Compose (Mempermudah setup local & production)
- **Testing Mail (Dev):** Mailpit

---

## 🚀 Panduan Setup Project (Dari Awal sampai Akhir)

### 1. Prasyarat Sistem
Pastikan di sistem/komputer Anda sudah terpasang:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- Git

### 2. Konfigurasi Awal (Environment Variables)
Salin file konfigurasi environment agar sesuai dengan environment lokal Anda:
```bash
cp www/.env.example www/.env
```
Buka file `www/.env` dan pastikan konfigurasi webhook n8n sudah benar untuk konektivitas Docker:
```env
N8N_WEBHOOK_URL=http://host.docker.internal:5678/webhook-test/e77b1f18-d182-42bb-b8f0-5354533dc1c2
```
> **Catatan:** `host.docker.internal` digunakan agar container Laravel bisa berkomunikasi dengan n8n yang di-host di komputer lokal (port 5678).

### 3. Menjalankan Container (Build & Up)
Buka terminal di direktori utama proyek (tempat file `docker-compose.yml` berada), lalu jalankan:
```bash
docker-compose up -d --build
```
Perintah ini akan men-download *image* yang diperlukan (MySQL, Redis, Mailpit, dll), membangun *image* aplikasi, dan menjalankan semua container di latar belakang (*detached mode*).

### 4. Setup Laravel (Dependencies & Database)
Masuk ke container dan jalankan setup standar Laravel:

**Install dependensi PHP (Composer):**
*(Pastikan Anda telah mengkonfigurasi file composer.json dan environment secara benar)*
```bash
docker exec -it laravel_app_sp composer install
```

**Generate Application Key:**
```bash
docker exec -it laravel_app_sp php artisan key:generate
```

**Import Database Komplit (Rekomendasi):**
Agar Anda mendapatkan database komplit (dengan 100+ katalog alat asli, barang, dan akun), gunakan file `database_full_terbaru.sql` untuk mengimpor seluruh data secara instan:
```bash
docker exec -i laravel_db_sp mysql -u user_laravel -psecret_password laravel_sp < database_full_terbaru.sql
```
*(Alternatif jika Anda hanya ingin data kosong/dummy awal: jalankan `docker exec -it laravel_app_sp php artisan migrate:fresh --seed`)*

**Tautkan Storage (Untuk Menampilkan Gambar Alat):**
Agar gambar-gambar katalog alat yang tersimpan bisa diakses oleh *browser*, Anda harus membuat *symlink* dengan perintah berikut:
```bash
docker exec -it laravel_app_sp php artisan storage:link
```

**Perbaiki Hak Akses Folder (Jika diperlukan):**
Jika Anda menemui masalah *"permission denied"* (misalnya file log atau cache tidak bisa ditulis), jalankan:
```bash
docker exec -u root laravel_app_sp chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
```

### 5. Konfigurasi n8n (Email Automation)
Sistem ini menggunakan n8n untuk mengirim email otomatis ketika ada peminjaman, persetujuan, atau penolakan alat.

1. Buka n8n di komputer lokal Anda: [http://localhost:5678](http://localhost:5678)
2. **Impor Workflow:** Buat Workflow baru, lalu buka menu *Options* (icon tiga titik di pojok kanan atas) -> **Import from File**. Pilih file `My_workflow.json` yang ada di direktori utama proyek. Semua node akan otomatis terkonfigurasi.
3. Konfigurasi **Webhook Node**:
   - Buka node Webhook, pastikan URL Path-nya sama dengan `N8N_WEBHOOK_URL` di file `.env` Laravel.
4. Konfigurasi Kredensial **Gmail**:
   - Klik pada node Gmail ("Send a message").
   - Pada bagian *Credential for Gmail API*, pilih *Create New Credential* dan sambungkan akun Gmail Anda mengikuti instruksi OAuth2 n8n agar bisa mengirimkan email notifikasi.
6. **Testing**: 
   - Klik **"Listen for test event"** pada Webhook node di n8n.
   - Buat peminjaman / update status peminjaman di aplikasi Laravel.
   - n8n akan menerima webhook dan mengirimkan email.
7. **Production Mode (Agar berjalan otomatis tanpa di klik "Listen for test event")**:
   - Di n8n, pastikan Anda mengubah endpoint Webhook node dari **Test** menjadi **Production**.
   - Copy URL Production webhook tersebut (misal: `/webhook/` bukan `/webhook-test/`).
   - Ubah `N8N_WEBHOOK_URL` di dalam file `.env` Laravel Anda. **PENTING:** Karena Laravel berjalan di dalam Docker, ganti kata `localhost` menjadi `n8n` agar aplikasi mengenali container n8n (contoh: `http://n8n:5678/webhook/...`).
   - Jangan lupa jalankan `docker exec -it laravel_app_sp php artisan config:clear` setelah mengubah `.env`.
   - Di n8n, klik tombol **"Publish"** di sudut kanan atas layar agar workflow selalu menyala di latar belakang.

---

## 🖥️ Akses Aplikasi & Layanan

Setelah semua berhasil berjalan, berikut adalah daftar akses layanan Anda:

- **Aplikasi Web (Laravel):** [http://localhost:8000](http://localhost:8000)
- **Mailpit (Dashboard Email Lokal):** [http://localhost:8025](http://localhost:8025) *(Digunakan jika email di route via Mailpit)*
- **n8n Webhook Dashboard:** [http://localhost:5678](http://localhost:5678)

### Akun Login Default (Seeder)
- **Admin:** (Sesuai dengan seeder, cek `DatabaseSeeder.php` atau `UserSeeder.php`)
- **Mahasiswa/Dosen:** (Tersedia beberapa akun dummy dari seeder)

---

## 🛠️ Perintah Berguna Lainnya (Cheatsheet)

- **Menghentikan Container:**
  ```bash
  docker-compose down
  ```
- **Melihat Log Aplikasi Container:**
  ```bash
  docker-compose logs -f app
  ```
- **Masuk ke dalam Shell Container Aplikasi:**
  ```bash
  docker exec -it laravel_app_sp bash
  ```
- **Menjalankan Perintah Artisan:**
  Setiap kali Anda ingin menjalankan `php artisan`, gunakan prefix container:
  ```bash
  docker exec -it laravel_app_sp php artisan <perintah>
  ```
  *(Catatan: Anda **tidak perlu** menjalankan `php artisan serve` karena web server yang ada di dalam container sudah secara otomatis melayani aplikasi).*

---
*Dokumentasi ini dikelola untuk memudahkan transisi handover proyek Sistem Informasi IPWIJA SmartLab.*
