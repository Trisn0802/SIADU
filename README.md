<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# SIADU - Sistem Informasi Aduan

## Sistem Notifikasi Dua Arah

### Fitur Baru: Assignment Petugas

Sistem ini telah diperbarui dengan fitur assignment petugas yang memungkinkan notifikasi yang lebih spesifik dan terorganisir.

#### Cara Kerja:

1. **Assignment Otomatis:**
   - Ketika admin mengubah status pengaduan dari "belum ditangani", admin tersebut otomatis ditugaskan ke pengaduan
   - Ketika petugas menerima pengaduan, petugas tersebut otomatis ditugaskan ke pengaduan

2. **Assignment Manual:**
   - Admin dapat menugaskan admin/petugas lain ke pengaduan melalui interface
   - Admin dapat menghapus assignment petugas dari pengaduan

3. **Notifikasi Spesifik:**
   - User hanya mengirim notifikasi ke petugas yang ditugaskan ke pengaduan mereka
   - Admin hanya mengirim notifikasi ke petugas yang ditugaskan ke pengaduan yang sama
   - Petugas hanya mengirim notifikasi ke admin yang ditugaskan ke pengaduan yang sama

#### Struktur Database Baru:

1. **Tabel `pengaduan_petugas`:**
   - `id_pengaduan`: ID pengaduan
   - `id_user`: ID admin/petugas
   - `role_petugas`: Role (admin/petugas)
   - `status_penanganan`: Status (aktif/nonaktif)
   - `assigned_at`: Waktu ditugaskan
   - `unassigned_at`: Waktu dihapus dari tugas

2. **Kolom baru di tabel `pengaduan`:**
   - `assigned_petugas`: ID petugas utama yang ditugaskan

#### Alur Notifikasi:

1. **User → Petugas/Admin:**
   - User mengirim chat
   - Notifikasi dikirim ke semua petugas/admin yang aktif menangani pengaduan tersebut

2. **Admin → User:**
   - Admin mengirim chat
   - Notifikasi dikirim ke user pengadu
   - Notifikasi juga dikirim ke petugas lain yang menangani pengaduan yang sama

3. **Petugas → User:**
   - Petugas mengirim chat
   - Notifikasi dikirim ke user pengadu
   - Notifikasi juga dikirim ke admin yang menangani pengaduan yang sama

#### Keuntungan:

1. **Notifikasi Lebih Relevan:** Hanya petugas yang benar-benar menangani yang menerima notifikasi
2. **Tracking Penanganan:** Dapat melacak siapa saja yang menangani pengaduan tertentu
3. **Fleksibilitas:** Admin dapat menugaskan multiple petugas ke satu pengaduan
4. **Akuntabilitas:** Jelas siapa yang bertanggung jawab menangani pengaduan

#### Cara Menggunakan:

1. **Untuk Admin:**
   - Buka detail pengaduan
   - Lihat section "Petugas yang Ditugaskan"
   - Gunakan form untuk menugaskan petugas baru
   - Klik tombol hapus untuk unassign petugas

2. **Untuk Petugas:**
   - Ketika menerima pengaduan, otomatis ditugaskan
   - Dapat melihat pengaduan yang ditugaskan di dashboard

3. **Untuk User:**
   - Tidak ada perubahan di interface
   - Notifikasi akan lebih relevan dan terorganisir
