# ServiceBooking - Penjelasan Aplikasi

## 1. Aplikasi ini untuk apa

`ServiceBooking` adalah aplikasi web untuk mengelola pemesanan layanan jasa secara online. Fokus utamanya adalah mempertemukan pelanggan dengan layanan tertentu, lalu memudahkan proses berikut:

- pelanggan melihat katalog layanan
- pelanggan memilih jadwal
- pelanggan membuat booking
- admin atau provider memantau dan memproses booking
- sistem menyimpan histori aktivitas booking
- pelanggan memberi review setelah layanan selesai
- admin melihat laporan operasional

Secara bisnis, aplikasi ini cocok untuk model usaha berbasis janji temu atau penjadwalan, misalnya:

- salon dan beauty service
- home cleaning
- perbaikan perangkat
- fotografi
- maintenance AC
- konsultasi

Di codebase saat ini, data demo memang sudah mengarah ke beberapa kategori itu.

## 2. Masalah yang diselesaikan

Sebelum ada aplikasi seperti ini, proses booking jasa biasanya tersebar di chat, telepon, spreadsheet, atau catatan manual. `ServiceBooking` merapikan proses itu menjadi satu alur terpusat:

- katalog layanan tersusun dan bisa dicari
- detail layanan, harga, durasi, dan provider terlihat jelas
- booking punya kode unik
- status booking bisa dilacak
- ada histori aktivitas tiap booking
- admin punya dashboard monitoring
- laporan bisa diekspor ke PDF dan Excel

Jadi, nilai utama aplikasinya adalah kombinasi antara:

- frontend publik untuk customer
- area akun customer untuk self-service
- panel operasional untuk admin/provider

## 3. Siapa saja user-nya

Di implementasi sekarang ada 3 role utama:

### 3.1 Customer

Customer adalah pengguna yang:

- registrasi dan login
- verifikasi email
- melihat daftar layanan
- membuka detail layanan
- membuat booking
- melihat dashboard pribadi
- melihat daftar booking miliknya
- membatalkan booking tertentu
- reschedule booking tertentu
- memberi review setelah booking selesai

Permission customer di seed saat ini minimal, tapi dari route dan policy memang customer adalah aktor utama di sisi public-facing booking flow.

### 3.2 Admin

Admin adalah pengelola operasional. Admin bisa:

- masuk ke panel `/admin`
- melihat statistik booking dan revenue
- melihat tabel booking terbaru
- mengelola booking
- approve booking
- reject booking
- complete booking
- mengelola service dan category
- melihat daftar customer
- melihat daftar provider
- melihat kalender booking
- melihat laporan
- export PDF dan Excel
- mengubah settings bisnis

Admin mendapat semua permission yang didefinisikan di `RolePermissionSeeder`.

### 3.3 Provider

Provider adalah pelaksana layanan. Di implementasi sekarang:

- provider juga bisa masuk ke panel `/admin`
- provider punya profil provider
- provider terhubung ke service tertentu
- provider bisa muncul sebagai penanggung jawab booking

Namun perlu dicatat: pada code sekarang, pengalaman provider masih menyatu dengan panel admin, belum ada panel provider yang benar-benar terpisah. Jadi secara konsep provider adalah role operasional, tetapi secara UX dan kontrol fitur masih berbagi area back-office dengan admin.

## 4. Flow aplikasi secara end-to-end

## 4.1 Flow publik

Pengunjung membuka halaman home `/`.

Di halaman ini sistem menampilkan:

- kategori aktif
- layanan unggulan
- testimonial review terbaru
- statistik total layanan, booking, dan customer
- FAQ

Tujuan halaman home adalah menjadi landing page sekaligus pintu masuk ke katalog layanan.

## 4.2 Flow eksplorasi layanan

Pengguna membuka `/services`.

Di halaman ini user bisa:

- mencari layanan berdasarkan nama atau ringkasan
- filter berdasarkan kategori
- filter rating minimum
- filter harga minimum dan maksimum
- filter availability
- sorting berdasarkan harga, rating, newest, atau popularitas

Setelah itu user membuka detail layanan di `/services/{slug}`.

Di detail layanan, user melihat:

- kategori layanan
- provider yang menangani
- profil provider
- review yang sudah ada
- layanan terkait

Flow ini menunjukkan bahwa aplikasi tidak hanya menyimpan booking, tapi juga membangun katalog yang cukup siap untuk kebutuhan marketplace jasa skala kecil.

## 4.3 Flow autentikasi

Sebelum booking, user harus login dan email-nya terverifikasi.

Flow auth yang tersedia:

- register
- login
- forgot password
- reset password
- email verification
- profile update
- password update
- hapus akun

Autentikasi dibangun dengan Laravel Breeze dan model `User` mengimplementasikan `MustVerifyEmail`.

## 4.4 Flow booking customer

Setelah login, customer bisa klik booking dari halaman detail service melalui `/services/{slug}/book`.

Pada tahap booking, user memilih:

- tanggal yang diinginkan
- jam yang diinginkan
- metode pembayaran
- data kontak dan alamat
- catatan tambahan

Sistem lalu membuat booking melalui `BookingWorkflowService`.

Saat booking dibuat, sistem melakukan hal berikut:

1. mengambil service yang dipilih
2. menghitung waktu selesai berdasarkan `duration_minutes`
3. menambahkan `admin_fee` sebesar `25000`
4. menghitung `total_price`
5. membuat `booking_code` unik dengan format `BK-YYYYMMDD-XXX`
6. menyimpan status awal `pending`
7. menyimpan `payment_status` awal `unpaid`
8. mencatat activity log `created`
9. mengirim email konfirmasi submission ke customer

Setelah sukses, user diarahkan ke halaman sukses booking.

## 4.5 Flow sesudah booking

Customer kemudian bisa membuka:

- `/dashboard`
- `/my-bookings`
- `/my-bookings/{booking}`

Di area ini customer bisa:

- melihat booking mendatang
- melihat histori booking
- melihat detail booking
- melihat timeline aktivitas booking
- cancel booking jika status masih mengizinkan
- reschedule booking jika status masih mengizinkan
- submit review jika status booking sudah `completed`

Policy booking saat ini mengatur:

- `cancel` boleh untuk `pending`, `approved`, `rescheduled`
- `reschedule` boleh untuk `pending`, `approved`
- `review` boleh hanya untuk `completed`

## 4.6 Flow operasional admin/provider

Admin dan provider bisa masuk ke Filament panel di `/admin`.

Di sana tersedia area berikut:

- Dashboard
- Bookings
- Services
- Categories
- Customers
- Staff / Providers
- Calendar
- Reports
- Settings

Flow kerja back-office yang terlihat dari implementasi:

1. booking masuk dengan status `pending`
2. admin meninjau booking dari tabel booking
3. admin bisa `approve` atau `reject`
4. setelah layanan dijalankan, admin bisa `complete`
5. saat complete, `payment_status` diubah menjadi `paid`
6. perubahan status dicatat ke `booking_activities`
7. data booking masuk ke laporan dan export

Tabel booking di panel juga mendukung:

- filter status
- filter service
- soft delete filter
- view detail
- edit manual

## 4.7 Flow review

Review hanya bisa diberikan customer jika booking sudah selesai.

Saat review dikirim:

- data review disimpan atau di-update
- `reviews_count` service dihitung ulang
- rata-rata `rating` service dihitung ulang

Ini penting karena rating service pada katalog bergantung pada review yang tersimpan.

## 5. Status dan lifecycle booking

Entity `Booking` punya lifecycle yang cukup jelas:

- `pending`
- `approved`
- `rejected`
- `completed`
- `cancelled`
- `rescheduled`

Maknanya:

- `pending`: booking baru dibuat dan menunggu konfirmasi
- `approved`: booking diterima
- `rejected`: booking ditolak
- `completed`: layanan selesai dijalankan
- `cancelled`: dibatalkan customer
- `rescheduled`: customer mengubah jadwal

Selain itu ada dimensi pembayaran:

- metode pembayaran: `pay_later`, `manual_transfer`
- status pembayaran: `unpaid`, `paid`, `refunded`

Jadi satu booking punya dua state terpisah:

- state operasional layanan
- state pembayaran

## 6. Struktur data utama

Secara domain, tabel utama aplikasi adalah:

### 6.1 `users`

Menyimpan akun pengguna:

- name
- email
- phone
- password
- email verification

Role tidak disimpan langsung di kolom user, tetapi melalui paket Spatie Permission.

### 6.2 `categories`

Menyimpan kategori layanan:

- name
- slug
- icon
- description
- is_active

### 6.3 `services`

Ini adalah master katalog layanan:

- category_id
- provider_id
- name
- slug
- description
- short_description
- price
- duration_minutes
- image
- rating
- reviews_count
- is_active

Relasi penting:

- satu service punya satu category
- satu service bisa punya satu provider
- satu service punya banyak booking
- satu service punya banyak review

### 6.4 `provider_profiles`

Menyimpan info tambahan provider:

- user_id
- bio
- phone
- status
- availability_notes

### 6.5 `bookings`

Ini adalah inti transaksi aplikasi:

- booking_code
- user_id
- service_id
- provider_id
- snapshot customer
- tanggal dan jam booking
- durasi
- harga layanan
- admin fee
- total harga
- status booking
- payment method
- payment status
- soft delete

Menariknya, tabel ini menyimpan snapshot data customer seperti nama, email, phone. Ini bagus untuk histori transaksi karena data tetap stabil walaupun profil user berubah nanti.

### 6.6 `booking_activities`

Tabel ini menyimpan timeline perubahan booking, misalnya:

- siapa yang melakukan aksi
- aksi apa yang dilakukan
- deskripsi aksi
- status lama
- status baru

Ini berguna untuk audit trail.

### 6.7 `reviews`

Menyimpan penilaian customer setelah layanan selesai:

- booking_id
- user_id
- service_id
- rating
- comment

### 6.8 `settings`

Menyimpan konfigurasi bisnis seperti:

- nama bisnis
- email kontak
- nomor telepon
- alamat
- jam operasional
- aturan booking
- informasi pembayaran
- notification settings

## 7. Teknologi yang dipakai

## 7.1 Backend

Teknologi backend utama:

- PHP `^8.3`
- Laravel `^13.8`

Laravel dipakai sebagai fondasi untuk:

- routing
- MVC
- authentication
- email verification
- validation
- Eloquent ORM
- migration dan seeder
- policy authorization
- mail

### Paket backend tambahan

- `laravel/breeze`
  Untuk auth scaffolding.
- `spatie/laravel-permission`
  Untuk role dan permission.
- `filament/filament`
  Untuk admin panel.
- `maatwebsite/excel`
  Untuk export laporan Excel.
- `barryvdh/laravel-dompdf`
  Untuk export laporan PDF.

## 7.2 Frontend

Stack frontend yang dipakai:

- Blade templates
- Tailwind CSS
- Alpine.js
- Vite

Implikasinya:

- frontend bukan SPA
- rendering utama tetap server-side
- interaksi ringan dibantu Alpine.js
- styling utilitas menggunakan Tailwind
- asset pipeline menggunakan Vite

Ini adalah kombinasi yang umum untuk aplikasi Laravel yang ingin cepat dibangun tetapi tetap punya UI modern.

## 7.3 Admin panel

Panel admin dibangun dengan Filament.

Manfaatnya:

- CRUD resource lebih cepat dibuat
- tabel, filter, action, dan form sudah siap pakai
- dashboard widget mudah dibangun
- cocok untuk area back-office

Di project ini, Filament dipakai untuk:

- resource bookings
- resource services
- resource categories
- halaman customers
- halaman providers
- halaman calendar
- halaman reports
- halaman settings
- widget statistik
- widget recent bookings

## 7.4 Database

README menyebut deployment diarahkan ke:

- MySQL
- MariaDB

Secara desain, model data aplikasi memang cocok untuk relational database karena relasinya cukup jelas:

- user ke booking
- provider ke service
- service ke review
- booking ke activity

## 8. Arsitektur aplikasi

Secara sederhana arsitekturnya adalah:

1. user mengakses route web Laravel
2. controller mengambil data dari model
3. validasi request dilakukan lewat Form Request
4. logika bisnis booking dipusatkan di `BookingWorkflowService`
5. output dirender ke Blade view atau Filament page
6. data disimpan lewat Eloquent ke database

Bagian yang cukup baik di implementasi ini adalah pemisahan logika booking ke service class. Artinya pembuatan booking, update status, reschedule, dan activity logging tidak ditaruh acak di controller.

## 9. Detail flow per modul

## 9.1 Modul Home

Tujuan:

- menarik pengunjung
- menunjukkan layanan unggulan
- membangun trust lewat review dan statistik

Sumber data:

- category
- service
- review
- booking

## 9.2 Modul Service Catalog

Tujuan:

- discovery layanan
- filtering
- mempermudah user membandingkan pilihan

Fitur utama:

- search
- filter kategori
- filter rating
- filter harga
- sorting
- related services

## 9.3 Modul Booking

Tujuan:

- mengubah minat customer menjadi transaksi booking

Logika utama:

- pilih service
- isi data customer
- pilih tanggal dan jam
- hitung durasi dan total biaya
- simpan booking
- kirim email
- buat activity log

## 9.4 Modul Customer Dashboard

Tujuan:

- memberi self-service ke customer setelah booking

Fitur utama:

- upcoming bookings
- booking history
- detail booking
- cancel
- reschedule
- review

## 9.5 Modul Admin Operations

Tujuan:

- memproses booking dan memantau operasional

Fitur utama:

- dashboard stats
- recent bookings
- booking management
- service management
- category management
- customer overview
- provider overview
- calendar snapshot
- reports
- settings

## 9.6 Modul Reporting

Tujuan:

- melihat performa operasional
- mengekspor data untuk stakeholder

Metrik yang dihitung:

- total bookings
- revenue completed bookings
- jumlah booking completed
- jumlah booking cancelled
- jumlah customer
- jumlah service
- breakdown status
- layanan terpopuler
- booking per bulan

Export tersedia dalam:

- PDF
- Excel

## 10. Demo data yang tersedia

Project ini sudah punya seeded demo data, jadi aplikasinya memang disiapkan untuk langsung dipresentasikan sebagai portfolio/demo product.

Akun demo:

- `admin@servicebooking.test` / `password`
- `customer@servicebooking.test` / `password`
- `provider@servicebooking.test` / `password`

Data demo lain yang tersedia:

- beberapa customer tambahan
- beberapa provider tambahan
- category layanan
- service aktif
- sample booking dengan status berbeda
- sample review
- default business settings

## 11. Kekuatan implementasi saat ini

- domain aplikasi jelas dan fokus
- flow booking end-to-end sudah terbentuk
- role customer, admin, provider sudah ada
- ada activity log untuk audit trail
- ada export report
- ada admin panel yang cukup lengkap untuk demo
- ada email submission saat booking dibuat
- ada review system yang meng-update rating service

## 12. Batasan atau catatan implementasi saat ini

Beberapa hal penting yang terlihat dari code sekarang:

- provider belum punya panel khusus yang benar-benar dipisah dari admin
- route admin custom untuk export/settings dibatasi `role:admin`, tetapi akses panel Filament sendiri dibuka untuk `admin` dan `provider`
- pilihan jadwal pada booking masih sederhana dan hardcoded
- belum terlihat mekanisme bentrok jadwal yang ketat
- payment gateway belum terintegrasi, masih sebatas metode `pay_later` dan `manual_transfer`
- kalender masih berupa tampilan data booking, belum scheduler interaktif penuh
- notifikasi email yang terlihat baru untuk booking submitted

Jadi aplikasi ini sudah kuat sebagai portfolio project atau fondasi MVP, tetapi belum sepenuhnya menjadi sistem booking enterprise-ready.

## 13. Kesimpulan

`ServiceBooking` adalah aplikasi booking jasa berbasis Laravel yang menggabungkan tiga area utama:

- katalog layanan untuk customer
- self-service booking management untuk customer
- panel operasional untuk admin/provider

Flow bisnisnya sudah masuk akal untuk usaha jasa: layanan dipublikasikan, customer melakukan booking, admin memproses status, aktivitas tercatat, lalu hasil operasional bisa dilihat di laporan.

Dari sisi teknologi, stack yang dipakai cukup modern untuk ekosistem Laravel:

- Laravel + Eloquent untuk backend
- Blade + Tailwind + Alpine untuk UI
- Filament untuk admin panel
- Spatie Permission untuk role
- DomPDF dan Excel untuk reporting

Kalau dilihat dari struktur dan fitur yang sudah ada, aplikasi ini paling tepat diposisikan sebagai:

- project portfolio full-stack Laravel
- fondasi MVP service booking
- template awal untuk bisnis jasa berbasis appointment

## 14. Referensi file penting

Kalau nanti kamu mau saya bedah lebih teknis lagi, file paling penting untuk dipelajari adalah:

- `routes/web.php`
- `app/Services/BookingWorkflowService.php`
- `app/Http/Controllers/ServiceController.php`
- `app/Http/Controllers/BookingController.php`
- `app/Http/Controllers/MyBookingController.php`
- `app/Models/Booking.php`
- `app/Models/Service.php`
- `app/Models/User.php`
- `app/Policies/BookingPolicy.php`
- `app/Providers/Filament/AdminPanelProvider.php`
- `app/Filament/Resources/Bookings/Tables/BookingsTable.php`
- `database/seeders/RolePermissionSeeder.php`
- `database/seeders/UserSeeder.php`
- `database/seeders/ServiceSeeder.php`
- `database/seeders/BookingSeeder.php`
