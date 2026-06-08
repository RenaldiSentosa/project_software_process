"# laravel_13" 

## Panduan Menjalankan Aplikasi dengan Docker

Aplikasi ini menggunakan Docker untuk mempermudah proses instalasi dan eksekusi di berbagai environment (pengembangan/lokal). Berikut adalah panduan langkah demi langkah untuk menjalankan aplikasi menggunakan Docker Compose.

### Prasyarat
Pastikan di sistem Anda sudah terpasang:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Langkah Menjalankan Aplikasi

1. **Jalankan Container (Build & Up)**
   Buka terminal di direktori utama proyek (tempat file `docker-compose.yml` berada), lalu jalankan:
   ```bash
   docker-compose up -d --build
   ```
   Perintah ini akan men-download *image* yang diperlukan (MySQL, Redis, Mailpit, dll), membangun *image* aplikasi, dan menjalankan semua container di latar belakang (*detached mode*).

2. **Jalankan Migration Database**
   Setelah container berjalan, lakukan migrasi database agar tabel-tabel terbuat:
   ```bash
   docker exec -it laravel_app_sp php artisan migrate
   ```

3. **Perbaiki Hak Akses Folder (Opsional namun Penting)**
   Jika Anda menemui masalah seperti *"tempnam(): file created in the system's temporary directory"* atau pesan error *permission denied*, jalankan perintah berikut untuk memastikan container memiliki akses tulis ke folder cache/log:
   ```bash
   docker exec -u root laravel_app_sp chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
   ```

4. **Akses Aplikasi**
   - **Aplikasi Web (Laravel):** Buka [http://localhost:8000](http://localhost:8000) di browser.
   - **Mailpit (Dashboard Email Lokal):** Buka [http://localhost:8025](http://localhost:8025) untuk memonitor email yang dikirimkan oleh aplikasi selama tahap testing.

### Perintah Lainnya

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
  Setiap kali Anda ingin menjalankan `php artisan` (misalnya untuk membuat *controller* atau *clear cache*), gunakan:
  ```bash
  docker exec -it laravel_app_sp php artisan <perintah>
  ```
  *(Catatan: Anda **tidak perlu** menjalankan `php artisan serve` karena Apache yang ada di dalam container sudah secara otomatis melayani aplikasi Anda).*
