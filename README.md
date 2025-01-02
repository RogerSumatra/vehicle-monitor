
## Deskripsi Aplikasi

Aplikasi ini merupakan sistem monitoring kendaraan. Fitur utama meliputi manajemen data booking, monitoring kendaraan, laporan dalam format Excel, konsumsi BBM, jadwal servis, riwayat pemakaian kendaraan, serta persetujuan pemakaian kendaraan secara berjenjang.

## Daftar Username dan Password

Berikut adalah daftar akun default yang dapat digunakan untuk mengakses aplikasi:

### Admin
| Email         | Password      |
| ------------- |:-------------:|
| admin@example.com      | password |

### Pihak Penyetuju
| Email         | Password      |
| ------------- |:-------------:|
| approverhead@example.com      | password |
| approverbranch@example.com      | password |
| approverminea@example.com      | password |
| approvermineb@example.com      | password |
| approverminec@example.com      | password |
| approvermined@example.com      | password |
| approverminee@example.com      | password |
| approverminef@example.com      | password |

## Spesifikasi

### Database

- MariaDB: Versi 10.4.32

### PHP

- PHP: Versi 8.2.12

### Framework

- Laravel: Versi 11.36.1

## Panduan

### Instalasi

1. Clone repository ke lokal
   ```
   git clone https://github.com/RogerSumatra/vehicle-monitor.git
   cd vehicle_monitor
   ```

2. Install semua dependensi
   ```
   composer install
   npm install && npm run dev
   ```

### Konfigurasi

1. Duplikat file `.env.example` menjadi `.env`:
   ```
   cp .env.example .env
   ```

3. Atur variabel ini `.env` sesuai dengan database anda
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
   ```

4. Dapatkan kunci aplikasi
   
   ```
   php artisan key:generate
   ```

5. Lakukan `migration` tabel ke database
   ```
   php artisan migrate
   ```

7. Lakukan `seed` untuk mengisi data ke database
   ```
   php artisan db:seed
   ```

### Menjalankan Aplikasi

1. Jalankan server lokal
   ```
   php artisan serve
   ```

3. Akses aplikasi melalui browser di alamat:
   ```
   http://127.0.0.1:8000
   ```
