# 📝 QUICK REFERENCE - Fitur Lupa Password & Ganti Password

## 🎯 Fitur yang Telah Diimplementasikan

### ✅ 1. Lupa Password di Login Page
**Route**: `GET /backend/forgot-password`
**View**: `resources/views/backend/v_forgot_password/request.blade.php`
- User input email terdaftar
- Sistem check email di database
- Jika ada: kirimkan email dengan link reset
- Jika tidak ada: tetap tampilkan pesan sukses (security)

### ✅ 2. Reset Password dengan Token
**Route**: `GET|POST /backend/reset-password/{token}`
**View**: `resources/views/backend/v_forgot_password/reset.blade.php`
- Link dari email berlaku 1 jam
- User input password baru (min 8 karakter)
- Real-time password strength validator
- Token otomatis dihapus setelah digunakan

### ✅ 3. Ganti Password dengan Verifikasi
**Routes**:
- User: `GET|PUT /backend/user/change-password/{id_user}`
- Admin: `GET|PUT /backend/admin/change-password/{id_user}`
- Petugas: `GET|PUT /backend/petugas/change-password/{id_user}`

**View**: `resources/views/backend/v_forgot_password/change_password.blade.php`
- User wajib input password lama untuk verifikasi
- Sistem verify dengan bcrypt hashing
- Password baru harus >= 8 karakter
- Auto redirect ke dashboard yang sesuai

### ✅ 4. UUID untuk Setiap User
- Auto-generate saat user register
- Disimpan di kolom `uuid` dengan UNIQUE constraint
- Meningkatkan keamanan (tidak pakai ID default 1,2,3...)

### ✅ 5. Email Notification
**Template**: `resources/views/backend/v_emails/reset_password.blade.php`
- Email berwarna dengan design modern
- Berisi link reset password
- Informasi waktu berlaku (1 jam)
- Tips keamanan password

---

## 📊 Files yang Ditambahkan

### Controllers
```
app/Http/Controllers/ForgotPasswordController.php (NEW)
```

### Views
```
resources/views/backend/v_forgot_password/request.blade.php (NEW)
resources/views/backend/v_forgot_password/reset.blade.php (NEW)
resources/views/backend/v_forgot_password/change_password.blade.php (NEW)
resources/views/backend/v_emails/reset_password.blade.php (NEW)
```

### Migrations
```
database/migrations/2025_02_12_000001_add_uuid_and_reset_columns_to_user_table.php (NEW)
```

### Modified Files
```
app/Models/User.php (boot method + fillable)
routes/web.php (new routes)
resources/views/backend/v_login/login.blade.php (link "Lupa Password?")
resources/views/backend/v_user/edit.blade.php (button "Ganti Password")
resources/views/backend/v_petugas/edit.blade.php (button "Ganti Password")
resources/views/backend/v_admin/edit.blade.php (button "Ganti Password")
```

---

## 🚀 Deployment Steps

### Local/Development
```bash
# 1. Run migration
php artisan migrate

# 2. Test semua routes
php artisan route:list

# 3. Test email (optional)
php artisan tinker
Mail::raw('Test', function ($m) { $m->to('test@example.com'); });
```

### Online Server
```bash
# 1. Push code ke git
git add .
git commit -m "Feat: Add forgot password and change password features"
git push

# 2. Di server
git pull origin main
php artisan migrate
```

---

## 🔐 Security Checklist

- ✅ UUID unique per user
- ✅ Reset token dengan 1 jam expiration
- ✅ Token berbeda setiap request
- ✅ Email enumeration protection
- ✅ Password verification untuk change password
- ✅ Bcrypt hashing untuk password
- ✅ Rate limiting bisa ditambahkan
- ✅ Error logging di storage/logs/laravel.log

---

## 🧪 Testing Quick Links

### Manual Testing
1. **Login page**: http://localhost/backend/login
   - Klik "Lupa Password?"
   
2. **Forgot password form**: http://localhost/backend/forgot-password
   - Input email yang terdaftar

3. **Reset password**: Check email untuk link reset
   - Klik link dan input password baru

4. **Edit profile**: http://localhost/backend/user/profile/{id}/edit
   - Klik button "Ganti Password"

5. **Change password**: http://localhost/backend/user/change-password/{id_user}
   - Input password lama
   - Input password baru

---

## 📞 Kontak untuk Support

**Developer**: Jawier
**Last Updated**: 12 Feb 2026
**Status**: ✅ Production Ready

---

## 📚 Dokumentasi Lengkap

Lihat file: `DOKUMENTASI_FORGOT_PASSWORD.md` untuk dokumentasi lebih lengkap
