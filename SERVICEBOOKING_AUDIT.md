# ServiceBooking Audit

## Ringkasan

`ServiceBooking` sudah cukup solid sebagai project demo atau portfolio karena alur utama customer booking sampai admin monitoring sudah ada. Tetapi kalau dinilai sebagai aplikasi yang siap dipakai operasional sungguhan, masih ada beberapa area yang belum beres, terutama pada:

- pembatasan akses antar role
- engine jadwal dan availability
- beberapa halaman admin yang masih sederhana
- beberapa bagian frontend yang masih statis
- kesiapan flow untuk skenario real-world

Secara umum, statusnya lebih tepat disebut:

- `MVP / portfolio-ready`
- belum `production-ready`

## 1. Fitur Yang Sudah Selesai atau Cukup Matang

### 1.1 Public website dan service discovery

Yang sudah ada:

- landing page publik
- katalog layanan
- detail layanan
- filter dan sorting layanan
- category listing
- related services
- testimonial/review section

Penilaian:

- sudah cukup bagus untuk demo user journey awal
- struktur domain layanan sudah jelas
- user sudah bisa memahami jenis layanan, provider, dan harga

### 1.2 Authentication dasar

Yang sudah ada:

- register
- login
- forgot password
- reset password
- email verification
- profile update
- password update
- delete account

Penilaian:

- untuk auth dasar, ini sudah cukup lengkap
- penggunaan Laravel auth flow sudah standar dan aman untuk skala MVP

### 1.3 Customer booking flow inti

Yang sudah ada:

- customer login lalu booking service
- form booking
- status awal `pending`
- kode booking otomatis
- perhitungan `admin_fee`
- perhitungan `total_price`
- halaman sukses booking
- riwayat booking customer
- detail booking customer
- cancel booking
- reschedule booking
- submit review setelah selesai

Penilaian:

- core transaction flow sudah terbentuk
- dari sisi demo produk, ini sudah menunjukkan value aplikasi

### 1.4 Booking activity log

Yang sudah ada:

- pencatatan activity ketika booking dibuat
- pencatatan perubahan status
- pencatatan reschedule

Penilaian:

- ini nilai tambah yang bagus
- audit trail sudah dipikirkan sejak awal

### 1.5 Admin panel dasar

Yang sudah ada:

- dashboard
- booking management
- service management
- category management
- customer overview
- provider overview
- report page
- settings page
- export PDF
- export Excel

Penilaian:

- cukup kuat untuk kebutuhan demo back-office
- pemakaian Filament membuat panel cepat usable

## 2. Fitur Yang Setengah Jadi atau Belum Beres

### 2.1 Pemisahan role admin dan provider

Status:

- belum beres

Masalah:

- `admin` dan `provider` sama-sama bisa masuk ke panel yang sama melalui `canAccessPanel()`
- belum ada pemisahan area kerja provider vs admin
- belum terlihat pembatasan resource dan action secara ketat untuk provider

Dampak:

- provider berpotensi melihat area yang seharusnya khusus admin
- provider berpotensi menjalankan aksi operasional yang terlalu besar
- struktur authorization belum siap untuk sistem real

Referensi:

- [app/Models/User.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Models/User.php:43)
- [app/Filament/Resources/Bookings/Tables/BookingsTable.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Filament/Resources/Bookings/Tables/BookingsTable.php:40)

### 2.2 Booking schedule dan availability

Status:

- masih placeholder / sederhana

Masalah:

- pilihan tanggal dan jam masih hardcoded
- belum ada slot dinamis dari provider
- belum ada validasi bentrok jadwal booking
- belum ada cek apakah provider sudah penuh di jam tertentu

Dampak:

- user bisa booking jam yang secara bisnis belum tentu valid
- risk double-booking tinggi
- belum layak untuk operasional sungguhan

Referensi:

- [app/Http/Controllers/ServiceController.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Http/Controllers/ServiceController.php:65)
- [app/Services/BookingWorkflowService.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Services/BookingWorkflowService.php:14)

### 2.3 Calendar page

Status:

- belum benar-benar menjadi kalender

Masalah:

- backend hanya mengambil 12 booking
- tampilan hanyalah grid kartu
- belum ada tampilan bulanan, mingguan, atau harian
- belum ada drag-drop atau visual slot scheduling

Dampak:

- secara nama fitur terdengar kuat, tapi implementasinya masih list visual
- ekspektasi user/admin bisa berbeda dengan hasil yang tampil

Referensi:

- [app/Filament/Pages/Calendar.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Filament/Pages/Calendar.php:19)
- [resources/views/filament/pages/calendar.blade.php](/D:/Fadlan/Pribadi/code/servicebooking/resources/views/filament/pages/calendar.blade.php:1)

### 2.4 Reports page

Status:

- sebagian selesai, sebagian belum termanfaatkan

Masalah:

- backend menghitung lebih banyak metrik daripada yang ditampilkan
- `monthlyBookings`, `cancelled`, `customers`, dan `services` belum benar-benar dipakai di UI
- report masih statis, belum ada filter periode

Dampak:

- data sudah ada tapi belum maksimal dipakai
- halaman report terasa belum tuntas

Referensi:

- [app/Filament/Pages/Reports.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Filament/Pages/Reports.php:21)
- [resources/views/filament/pages/reports.blade.php](/D:/Fadlan/Pribadi/code/servicebooking/resources/views/filament/pages/reports.blade.php:1)

### 2.5 Provider workflow

Status:

- belum matang

Masalah:

- provider profile memang ada
- provider bisa di-assign ke service dan booking
- tetapi belum ada workflow provider yang lengkap, misalnya:
  - daftar booking khusus provider
  - status availability provider yang benar-benar aktif
  - aksi provider yang dibatasi sesuai tanggung jawab
  - dashboard provider yang fokus ke jadwal sendiri

Dampak:

- role provider baru terasa “ada”, belum terasa “selesai”

### 2.6 Settings

Status:

- dasar ada, tapi belum menyentuh semua kebutuhan operasional

Masalah:

- settings disimpan di database
- tetapi belum terlihat semua settings benar-benar dipakai secara menyeluruh di frontend/backend
- belum ada konfigurasi bisnis yang lebih lanjut seperti:
  - lead time booking
  - jam operasional per hari
  - durasi buffer antar booking
  - aturan cancel/reschedule

Dampak:

- settings masih lebih dekat ke konten bisnis, belum menjadi rules engine operasional

## 3. Temuan Backend

### 3.1 Authorization belum ketat

Severity:

- tinggi

Masalah utama:

- panel admin/provider masih dibagi
- action booking di table tidak terlihat dibatasi per role

Risiko:

- provider bisa melakukan aksi yang seharusnya hanya untuk admin

### 3.2 Booking code generation rawan bentrok

Severity:

- sedang

Masalah utama:

- kode booking dibentuk dari jumlah booking hari itu `count() + 1`
- jika dua request masuk hampir bersamaan, bisa menghasilkan kode sama

Risiko:

- collision pada `booking_code`
- error insert saat traffic naik

Referensi:

- [app/Services/BookingWorkflowService.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Services/BookingWorkflowService.php:110)

### 3.3 Tidak ada conflict detection untuk jadwal

Severity:

- tinggi

Masalah utama:

- booking dibuat tanpa cek bentrok provider pada tanggal dan jam yang sama

Risiko:

- double-booking
- provider overload
- pengalaman operasional buruk

### 3.4 Payment flow masih sangat sederhana

Severity:

- sedang

Masalah utama:

- payment method hanya `pay_later` dan `manual_transfer`
- tidak ada bukti pembayaran
- tidak ada verifikasi pembayaran
- tidak ada payment callback

Risiko:

- payment status bergantung pada update manual
- belum cocok untuk transaksi real

### 3.5 Notifikasi belum lengkap

Severity:

- sedang

Masalah utama:

- yang terlihat jelas baru email saat booking dibuat
- belum terlihat notifikasi untuk approve, reject, reschedule, complete, reminder, atau cancel

Risiko:

- user kurang mendapat update
- admin/provider harus follow-up manual

### 3.6 Reporting query masih sederhana

Severity:

- rendah sampai sedang

Masalah utama:

- report mengambil semua data lalu mengolahnya di memory collection
- untuk data kecil aman
- untuk data besar akan berat

Risiko:

- performa turun saat data booking bertambah besar

Referensi:

- [app/Filament/Pages/Reports.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Filament/Pages/Reports.php:23)

## 4. Temuan Frontend

### 4.1 Booking summary masih statis

Severity:

- sedang

Masalah utama:

- sidebar booking menampilkan tanggal dan jam statis
- belum mengikuti input user secara dinamis

Risiko:

- user bisa salah paham terhadap jadwal yang dipilih
- terasa belum selesai secara UX

Referensi:

- [resources/views/pages/bookings/create.blade.php](/D:/Fadlan/Pribadi/code/servicebooking/resources/views/pages/bookings/create.blade.php:69)

### 4.2 Booking steps bersifat visual saja

Severity:

- rendah

Masalah utama:

- step booking tampil seperti wizard
- tetapi sebenarnya bukan multi-step form interaktif

Risiko:

- UI memberi ekspektasi lebih dari perilaku aslinya

### 4.3 Validasi form belum terasa matang

Severity:

- sedang

Masalah utama:

- validasi request ada di backend
- tetapi pengalaman error handling di form belum terlihat kuat
- tidak tampak komponen error per field yang rapi di form booking

Risiko:

- UX input form kurang nyaman saat user salah isi

Referensi:

- [app/Http/Requests/StoreBookingRequest.php](/D:/Fadlan/Pribadi/code/servicebooking/app/Http/Requests/StoreBookingRequest.php:16)
- [resources/views/pages/bookings/create.blade.php](/D:/Fadlan/Pribadi/code/servicebooking/resources/views/pages/bookings/create.blade.php:16)

### 4.4 Calendar dan reports terasa placeholder

Severity:

- sedang

Masalah utama:

- nama fiturnya besar
- tampilan aktualnya masih sederhana

Risiko:

- secara presentasi portfolio masih oke
- secara produk nyata terasa belum selesai

### 4.5 Belum terlihat UX loading, empty states, dan feedback yang konsisten di semua halaman

Severity:

- rendah sampai sedang

Masalah utama:

- beberapa halaman sudah punya komponen UI baik
- tetapi secara menyeluruh belum terlihat standar feedback yang konsisten untuk:
  - loading state
  - error state
  - empty state
  - success confirmation yang kaya konteks

Risiko:

- pengalaman pengguna terasa campuran antara polished dan basic

## 5. Bug atau Risiko Fungsional Yang Paling Penting

Berikut yang paling layak dianggap prioritas:

1. Provider dan admin belum dipisah tegas dalam akses panel dan aksi.
2. Booking belum mengecek bentrok jadwal provider.
3. Booking code generation rawan bentrok pada request paralel.
4. Booking summary di frontend masih menampilkan data statis.
5. Report dan calendar belum sesuai ekspektasi nama fiturnya.

## 6. Prioritas Perbaikan Backend

### Prioritas 1

- pisahkan hak akses `admin` dan `provider`
- batasi resource dan action Filament per role
- tambahkan query scoping untuk provider agar hanya melihat data miliknya

### Prioritas 2

- tambahkan engine availability
- validasi konflik jadwal sebelum booking dibuat
- pertimbangkan buffer time antar booking

### Prioritas 3

- ganti strategi pembuatan booking code agar aman terhadap race condition
- bisa pakai UUID/ULID, sequence table, atau retry mechanism

### Prioritas 4

- perluas notification flow
- kirim notifikasi saat approve, reject, reschedule, completed

### Prioritas 5

- optimalkan reporting query agar agregasi tidak seluruhnya diproses di memory

## 7. Prioritas Perbaikan Frontend

### Prioritas 1

- jadikan booking summary dinamis berdasarkan input form
- perjelas feedback jadwal, total harga, dan payment method

### Prioritas 2

- rapikan error handling form booking
- tampilkan pesan validasi per field

### Prioritas 3

- putuskan apakah booking form benar-benar wizard atau tetap single-page form
- kalau wizard, implementasikan step state yang nyata
- kalau bukan wizard, hilangkan visual step yang misleading

### Prioritas 4

- upgrade calendar menjadi kalender yang benar-benar interaktif atau ubah naming/ekspektasi fiturnya

### Prioritas 5

- perluas report UI dengan grafik, filter tanggal, dan semua metrik yang sudah dihitung backend

## 8. Rekomendasi Posisi Aplikasi Saat Ini

Saat ini `ServiceBooking` paling cocok diposisikan sebagai:

- portfolio project full-stack Laravel
- MVP service booking
- starter kit untuk aplikasi jasa berbasis appointment

Belum ideal diposisikan sebagai:

- sistem booking produksi multi-role yang matang
- sistem scheduling operasional dengan kontrol slot real-time
- sistem transaksi jasa dengan payment automation penuh

## 9. Kesimpulan Akhir

Kalau ditanya “apakah ada fitur yang belum beres?”, jawabannya: `ya, ada`.

Yang paling jelas belum beres bukan pada fondasi dasarnya, tetapi pada pendalaman fitur:

- authorization multi-role
- scheduling real
- provider workflow
- report/calendar yang lebih matang
- polish UX frontend

Artinya fondasi aplikasinya sudah ada, namun masih perlu satu putaran penguatan agar naik dari level demo/MVP ke level aplikasi operasional yang lebih siap dipakai.
