# 🗄️ DATABASE SCHEMA CHANGES

## Migration yang Ditambahkan

**File**: `database/migrations/2025_02_12_000001_add_uuid_and_reset_columns_to_user_table.php`

### Kolom Baru di Table `user`

#### 1. `uuid` (string, unique, nullable)
```sql
ALTER TABLE user ADD COLUMN uuid VARCHAR(255) UNIQUE NULLABLE AFTER id_user;
```
**Fungsi**: Unique identifier untuk setiap user, meningkatkan security
**Default**: Auto-generate saat user dibuat di Model boot method
**Example**: `550e8400-e29b-41d4-a716-446655440000`

#### 2. `reset_token` (string, unique, nullable)
```sql
ALTER TABLE user ADD COLUMN reset_token VARCHAR(255) UNIQUE NULLABLE AFTER otp_verified;
```
**Fungsi**: Token untuk reset password confirmation
**Lifetime**: 1 jam dari saat request
**Default**: NULL (hanya ada saat ada reset password request aktif)
**Example**: `abcdef1234567890abcdef1234567890abcdef1234567890abcdef1234` (64 chars)

#### 3. `reset_token_expires_at` (timestamp, nullable)
```sql
ALTER TABLE user ADD COLUMN reset_token_expires_at TIMESTAMP NULLABLE AFTER reset_token;
```
**Fungsi**: Waktu kadaluarsa untuk reset token
**Default**: NULL (hanya ada saat ada reset password request aktif)
**Lifetime**: now() + 1 hour
**Example**: `2025-02-12 14:30:00`

### Index yang Ditambahkan

```sql
CREATE INDEX user_uuid_index ON user(uuid);
```
**Fungsi**: Mempercepat query filter by UUID

---

## Before & After Struktur User Table

### BEFORE
```
id_user (bigint, primary)
nama (string)
nik (string)
email (string, unique)
instansi (string, nullable)
role (enum: 0,1,2)
status (tinyint)
password (string)
no_hp (string, nullable)
foto (string, nullable)
remember_token (string, nullable)
created_at (timestamp)
updated_at (timestamp)
otp_verified (boolean)
```

### AFTER
```
id_user (bigint, primary)
uuid (string, unique, nullable) ← NEW
nama (string)
nik (string)
email (string, unique)
instansi (string, nullable)
role (enum: 0,1,2)
status (tinyint)
password (string)
no_hp (string, nullable)
foto (string, nullable)
remember_token (string, nullable)
otp_verified (boolean)
reset_token (string, unique, nullable) ← NEW
reset_token_expires_at (timestamp, nullable) ← NEW
created_at (timestamp)
updated_at (timestamp)
```

---

## Sample SQL Queries

### Membuat User Baru (dengan auto UUID)
```sql
INSERT INTO user (nama, nik, email, password, created_at, updated_at)
VALUES ('John Doe', '1234567890123456', 'john@example.com', 'hashed_password', NOW(), NOW());

-- UUID auto-generate via Model boot method
SELECT uuid FROM user WHERE email = 'john@example.com';
-- Output: 550e8400-e29b-41d4-a716-446655440000
```

### Reset Password Request
```sql
UPDATE user 
SET reset_token = 'random_token_64_chars',
    reset_token_expires_at = DATE_ADD(NOW(), INTERVAL 1 HOUR)
WHERE email = 'john@example.com';
```

### Verify Reset Token
```sql
SELECT * FROM user
WHERE reset_token = 'random_token_64_chars'
AND reset_token_expires_at > NOW()
AND reset_token IS NOT NULL;
```

### Complete Reset Password
```sql
UPDATE user
SET password = 'new_hashed_password',
    reset_token = NULL,
    reset_token_expires_at = NULL
WHERE reset_token = 'random_token_64_chars';
```

---

## Rollback Instructions

Jika perlu rollback migration:

```bash
# Rollback 1 step (ke previous migration)
php artisan migrate:rollback --step=1

# Atau rollback specific migration
php artisan migrate:rollback --path=database/migrations/2025_02_12_000001_add_uuid_and_reset_columns_to_user_table.php
```

---

## Existing Users UUID Population (Opsional)

Jika ada existing users yang belum punya UUID (sebelum migration):

```sql
-- Generate UUID untuk users yang masih NULL
UPDATE user 
SET uuid = UUID()
WHERE uuid IS NULL;
```

Atau via Artisan Command (buat jika perlu):

```bash
php artisan tinker
User::whereNull('uuid')->each(fn($user) => $user->update(['uuid' => Str::uuid()]));
```

---

## Verifikasi Schema

Untuk memverifikasi schema sudah benar:

```bash
# Via artisan
php artisan migrate:status

# Via tinker
php artisan tinker
DB::table('user')->getConnection()->getSchemaBuilder()->getColumnListing('user');
```

---

## Performance Impact

- ✅ **Minimal** - hanya 3 kolom tambahan (string, string, timestamp)
- ✅ **Index pada UUID** untuk fast lookup
- ✅ **Reset token unique** untuk consistency
- ⚠️ **Table size**: +/- 50-100 bytes per row (depending on token length)

---

## Backward Compatibility

- ✅ Existing users: Bisa langsung gunakan fitur lupa password
- ✅ UUID: Auto-generate saat user di-update atau user baru dibuat
- ✅ Reset token: NULL untuk users yang belum request reset
- ✅ **Zero downtime migration**: Kolom baru, tidak modify existing

---

## Production Checklist

Sebelum go live:

- [ ] Run migration di server: `php artisan migrate`
- [ ] Verify columns ada: `php artisan tinker` → `DB::table('user')->first()`
- [ ] Test UUID generation: Register user baru dan check UUID
- [ ] Test reset password: Go through full flow
- [ ] Backup database sebelum migration
- [ ] Monitor error logs: `tail -f storage/logs/laravel.log`
