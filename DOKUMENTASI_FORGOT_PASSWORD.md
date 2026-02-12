# DOKUMENTASI FITUR LUPA PASSWORD DAN GANTI PASSWORD

## 📋 Ringkasan Fitur yang Diimplementasikan

Fitur keamanan password yang komprehensif telah ditambahkan ke aplikasi SIADU dengan fitur-fitur berikut:

### 1. **Fitur Lupa Password di Login Page**
- User dapat mengklik link "Lupa Password?" di halaman login
- Form untuk input email terdaftar
- Sistem akan mengirimkan email verifikasi ke alamat yang terdaftar
- **Keamanan**: Jika email tidak ditemukan, tetap tampilkan pesan "Verifikasi email telah dikirim" untuk mencegah email enumeration

### 2. **UUID Unik untuk Setiap User**
- Saat user baru terdaftar, sistem otomatis generate UUID unik
- UUID tersimpan di kolom `uuid` di table `user`
- Fungsi keamanan: Meningkatkan keamanan karena ID default (1,2,3) tidak lagi digunakan

### 3. **Reset Password dengan Token**
- User menerima email dengan link reset password
- Link hanya berlaku selama **1 jam**
- Token reset disimpan di database dengan masa berlaku yang terbatas
- User dapat mengatur password baru dengan requirement 8 karakter minimal
- Validasi kekuatan password real-time (Lemah/Sedang/Kuat)

### 4. **Ganti Password dengan Verifikasi Password Lama**
- User/Petugas/Admin dapat mengubah password dari halaman edit profile
- **Wajib** mengisi password lama terlebih dahulu untuk verifikasi
- Sistem akan memverifikasi kecocokan password lama sebelum perubahan
- Update password hanya jika verifikasi berhasil

### 5. **Fitur Lupa Password di Edit Page**
- Di setiap page edit (user/petugas/admin), ada button "Lupa Password?"
- Membuka form untuk input email
- User bisa memilih reset password tanpa harus login ulang

---

## 🗂️ Database Changes

### New Migration File
```
database/migrations/2025_02_12_000001_add_uuid_and_reset_columns_to_user_table.php
```

### New Columns Added to `user` Table
1. **`uuid`** (string, unique) - Unique identifier untuk setiap user
2. **`reset_token`** (string, nullable, unique) - Token untuk reset password
3. **`reset_token_expires_at`** (timestamp, nullable) - Waktu expired untuk reset token

---

## 🎮 Controller & Routes

### New Controller
```
app/Http/Controllers/ForgotPasswordController.php
```

### Methods di ForgotPasswordController
1. `showForgotPasswordForm()` - Tampilkan form email
2. `sendResetLink()` - Kirim email reset password
3. `showResetPasswordForm()` - Tampilkan form reset password
4. `resetPassword()` - Process reset password
5. `showChangePasswordForm()` - Tampilkan form ganti password
6. `changePassword()` - Process ganti password dengan verifikasi

### Routes yang Ditambahkan
```php
// Forgot Password (guest only)
GET  /backend/forgot-password                    → password.forgot.form
POST /backend/forgot-password                    → password.send.reset.link
GET  /backend/reset-password/{token}             → password.reset.form
POST /backend/reset-password                     → password.reset.process

// Change Password (authorized users)
GET  /backend/user/change-password/{id_user}     → password.forgot.form.change
PUT  /backend/user/change-password/{id_user}     → password.change.process

GET  /backend/admin/change-password/{id_user}    → password.forgot.form.change.admin
PUT  /backend/admin/change-password/{id_user}    → password.change.process.admin

GET  /backend/petugas/change-password/{id_user}  → password.forgot.form.change.petugas
PUT  /backend/petugas/change-password/{id_user}  → password.change.process.petugas
```

---

## 📧 Email Configuration

### SMTP Configuration (sudah terkonfigurasi di .env)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=trisnawisesa20@gmail.com
MAIL_PASSWORD=smcc nely hqax bgfo (App Password Gmail)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=trisnawisesa20@gmail.com
MAIL_FROM_NAME=SIADU
```

### Email Template
```
resources/views/backend/v_emails/reset_password.blade.php
```
Email berisi:
- Link reset password (berlaku 1 jam)
- Peringatan keamanan
- Instruksi untuk user

---

## 🔐 Keamanan yang Diimplementasikan

### 1. **Token-based Reset Password**
- Setiap reset request mendapat token unik (64 karakter random)
- Token hanya berlaku 1 jam
- Token otomatis dihapus setelah digunakan
- Token disimpan di DB dengan encrypted

### 2. **Password Verification**
- Saat ganti password, user harus input password lama
- Sistem verify dengan bcrypt hashing
- Mencegah unauthorized password changes

### 3. **Email Enumeration Protection**
- Jika email tidak ditemukan, tetap tampilkan pesan sukses
- Attacker tidak bisa tahu email mana yang terdaftar atau tidak
- Sistem hanya kirim email jika email ditemukan

### 4. **UUID for Better Security**
- Setiap user punya UUID unik
- Tidak ada user dengan ID default (1,2,3...)
- Lebih sulit untuk brute force atau predictable IDs

### 5. **Password Strength Validation**
- Minimum 8 karakter
- Real-time strength indicator
- Encourage kombinasi huruf besar, kecil, angka, simbol

### 6. **Rate Limiting** (Opsional - bisa ditambahkan)
- Bisa limit email reset 1x per jam per email
- Bisa limit attempts untuk reset password

---

## 📁 Views yang Ditambahkan/Dimodifikasi

### New Views
1. `resources/views/backend/v_forgot_password/request.blade.php`
   - Form untuk request email lupa password

2. `resources/views/backend/v_forgot_password/reset.blade.php`
   - Form untuk reset password dengan token
   - Includes password strength indicator

3. `resources/views/backend/v_forgot_password/change_password.blade.php`
   - Form untuk ganti password dengan verifikasi password lama
   - Available untuk user, petugas, dan admin

4. `resources/views/backend/v_emails/reset_password.blade.php`
   - Email template untuk reset password notification

### Modified Views
1. `resources/views/backend/v_login/login.blade.php`
   - Tambahan link "Lupa Password?"

2. `resources/views/backend/v_user/edit.blade.php`
   - Button "Ganti Password" dengan verifikasi

3. `resources/views/backend/v_petugas/edit.blade.php`
   - Button "Ganti Password" dengan verifikasi

4. `resources/views/backend/v_admin/edit.blade.php`
   - Button "Ganti Password" dengan verifikasi

---

## 🧪 Testing Checklist

### Test Skenario 1: Lupa Password di Login
- [ ] Klik "Lupa Password?" di login page
- [ ] Input email yang terdaftar
- [ ] Verifikasi email diterima dengan link reset
- [ ] Klik link di email
- [ ] Input password baru
- [ ] Verifikasi password berhasil diubah
- [ ] Login dengan password baru

### Test Skenario 2: Lupa Password dengan Email Tidak Terdaftar
- [ ] Input email yang tidak terdaftar
- [ ] Verify pesan tetap "Verifikasi email telah dikirim"
- [ ] Pergi ke email - tidak ada email dikirim

### Test Skenario 3: Ganti Password dari Edit Profile
- [ ] Login sebagai user/petugas/admin
- [ ] Go to edit profile page
- [ ] Klik button "Ganti Password"
- [ ] Form muncul dengan field password lama
- [ ] Input password lama yang salah → error
- [ ] Input password lama yang benar
- [ ] Input password baru
- [ ] Verifikasi password berhasil diubah

### Test Skenario 4: Token Expiration
- [ ] Request reset password
- [ ] Tunggu lebih dari 1 jam
- [ ] Coba akses link reset → error "Link tidak valid"

### Test Skenario 5: Password Strength Indicator
- [ ] Input berbagai kombinasi password
- [ ] Verifikasi indicator berubah ke Lemah/Sedang/Kuat
- [ ] Verifikasi hanya password >= 8 karakter bisa disubmit

### Test Skenario 6: UUID Generation
- [ ] Register user baru
- [ ] Check database - user punya UUID unik
- [ ] UUID berbeda untuk setiap user

---

## 📝 Model Updates

### User Model
```php
// Boot method untuk auto-generate UUID
protected static function boot()
{
    parent::boot();
    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = \Illuminate\Support\Str::uuid();
        }
    });
}

// Fillable attributes diupdate dengan:
'uuid', 'reset_token', 'reset_token_expires_at'
```

---

## 🚀 Deployment Instructions

Platform online sudah bisa langsung deploy karena:
1. ✅ Migration files sudah ready
2. ✅ Semua logic sudah di controller
3. ✅ Email configuration sudah di .env
4. ✅ UUID auto-generate di boot method

### Di Server Online:
```bash
php artisan migrate
# atau dengan step
php artisan migrate --step
```

---

## ⚠️ Catatan Penting

1. **Email Configuration**: Pastikan credentials Gmail sudah benar di .env
2. **Gmail App Password**: Saat ini menggunakan App Password, bukan password Gmail biasa
3. **Token Expiration**: Default 1 jam, bisa diubah di ForgotPasswordController
4. **Rate Limiting**: Pertimbangkan untuk tambah rate limiting jika diperlukan
5. **Logging**: Error email akan di-log di `storage/logs/laravel.log`

---

## 🔧 Troubleshooting

### Email tidak terkirim
1. Check .env MAIL_* configuration
2. Check `storage/logs/laravel.log` untuk error
3. Verify Gmail credentials dan App Password
4. Pastikan "Less secure apps" atau "App Passwords" diaktifkan

### Reset token invalid
1. Check waktu server dan database
2. Verify token di database tidak sudah expired
3. Check RESET_TOKEN dalam session

### Password strength indicator tidak work
1. Pastikan JavaScript diloadkan dengan benar
2. Check browser console untuk error
3. Verify no JavaScript errors di viewport

---

## 📞 Support

Untuk issues atau questions, hubungi tim development.
