# 🔄 FLOW DIAGRAM - Fitur Lupa Password & Ganti Password

## 📊 Forgot Password Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                     USER FORGOT PASSWORD FLOW                        │
└─────────────────────────────────────────────────────────────────────┘

1. LOGIN PAGE
   ↓
   [Klik "Lupa Password?" Link]
   ↓
   
2. FORGOT PASSWORD FORM PAGE
   Route: GET /backend/forgot-password
   View: resources/views/backend/v_forgot_password/request.blade.php
   ├─ Form Input: Email
   └─ Submit Button: "Kirim Link Reset"
   ↓
   
3. SEND RESET LINK (Controller: ForgotPasswordController@sendResetLink)
   ├─ Validate email input
   ├─ Query: Find user by email
   │
   ├─ IF email found:
   │  ├─ Generate random token (64 chars)
   │  ├─ Update user:
   │  │  ├─ reset_token = generated_token
   │  │  └─ reset_token_expires_at = now() + 1 hour
   │  ├─ Send email dengan link:
   │  │  └─ /backend/reset-password/{token}
   │  └─ Response: Success message
   │
   └─ IF email NOT found:
      └─ Response: Same success message (security: email enumeration prevention)
   ↓
   
4. USER RECEIVES EMAIL
   ├─ Template: resources/views/backend/v_emails/reset_password.blade.php
   ├─ Contains:
   │  ├─ Link: /backend/reset-password/{token}
   │  ├─ Expiration info: "Valid for 1 hour"
   │  └─ Security tips
   └─ User clicks link
   ↓
   
5. RESET PASSWORD FORM PAGE
   Route: GET /backend/reset-password/{token}
   Controller: ForgotPasswordController@showResetPasswordForm
   ├─ Verify token:
   │  ├─ Query: Find user with reset_token = {token}
   │  ├─ Check: reset_token_expires_at > NOW()
   │  │
   │  ├─ IF valid:
   │  │  └─ Show form
   │  │
   │  └─ IF invalid/expired:
   │     └─ Redirect to login with error message
   │
   └─ Form Input:
      ├─ Password baru (min 8 chars)
      ├─ Confirm password baru
      └─ Password strength indicator (real-time)
   ↓
   
6. RESET PASSWORD (Controller: ForgotPasswordController@resetPassword)
   ├─ Validate:
   │  ├─ Token exists & not expired
   │  ├─ Password minimum 8 chars
   │  └─ Password confirmation matches
   │
   ├─ Update user:
   │  ├─ password = bcrypt(new_password)
   │  ├─ reset_token = NULL
   │  └─ reset_token_expires_at = NULL
   │
   └─ Redirect to login with success message
   ↓
   
7. USER LOGIN
   └─ Login dengan password baru yang sudah direset
   
   
┌─────────────────────────────────────────────────────────────────────┐
│                    SECURITY CHECKS                                   │
├─────────────────────────────────────────────────────────────────────┤
│ ✓ Email enumeration prevention                                      │
│ ✓ Token 1 hour expiration                                           │
│ ✓ Token unique & random (64 chars)                                  │
│ ✓ Password bcrypt hashing                                           │
│ ✓ Token deleted after use                                           │
│ ✓ CSRF protection on forms                                          │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 📋 Change Password Flow (dengan Verifikasi Password Lama)

```
┌─────────────────────────────────────────────────────────────────────┐
│                   CHANGE PASSWORD FLOW                               │
└─────────────────────────────────────────────────────────────────────┘

1. USER DASHBOARD / EDIT PROFILE PAGE
   ├─ User profile page (user/petugas/admin)
   └─ Button: "Ganti Password"
   ↓
   
2. ROUTE MAPPING
   User:    /backend/user/profile/{id}/edit → Button: Ganti Password
            ↓
            route('password.forgot.form.change', ['id_user' => $id])
   
   Petugas: /backend/petugas/edit → Button: Ganti Password
            ↓
            route('password.forgot.form.change.petugas', ['id_user' => $id])
   
   Admin:   /backend/admin/user/{id}/edit → Button: Ganti Password
            ↓
            route('password.forgot.form.change.admin', ['id_user' => $id])
   ↓
   
3. CHANGE PASSWORD FORM PAGE
   Route: GET /backend/user/change-password/{id_user}
          GET /backend/admin/change-password/{id_user}
          GET /backend/petugas/change-password/{id_user}
   
   Controller: ForgotPasswordController@showChangePasswordForm
   ├─ Query: Find user by id_user
   ├─ Determine userType by user.role:
   │  ├─ role == 0 → 'user'
   │  ├─ role == 1 → 'admin'
   │  └─ role == 2 → 'petugas'
   │
   └─ Show form dengan fields:
      ├─ Password Lama (input text, show/hide toggle)
      ├─ Password Baru (input text, show/hide toggle)
      │  └─ Real-time strength indicator
      ├─ Confirm Password Baru (input text, show/hide toggle)
      └─ Buttons: [Ubah Password] [Lupa Password?] [Kembali]
   ↓
   
4. PROCESS CHANGE PASSWORD
   Route: PUT /backend/user/change-password/{id_user}
          PUT /backend/admin/change-password/{id_user}
          PUT /backend/petugas/change-password/{id_user}
   
   Controller: ForgotPasswordController@changePassword
   ├─ Validate:
   │  ├─ password_lama required
   │  ├─ password_baru required, min 8 chars
   │  └─ password_baru confirmation matches
   │
   ├─ Verify password lama:
   │  ├─ Query: Find user by id_user
   │  ├─ Compare: Hash::check(input_password, user.password)
   │  │
   │  ├─ IF match:
   │  │  └─ Continue to update
   │  │
   │  └─ IF NOT match:
   │     └─ Redirect back with error: "Password lama tidak sesuai"
   │
   ├─ Update password:
   │  └─ user.password = bcrypt(password_baru)
   │
   ├─ Determine redirect route by user.role:
   │  ├─ role == 0 → redirect backend.beranda.user
   │  ├─ role == 1 → redirect backend.user.showUser
   │  └─ role == 2 → redirect backend.petugas.dashboard
   │
   └─ Redirect with success message
   ↓
   
5. SUCCESS
   └─ Password changed, user dapat login dengan password baru
   
   
┌─────────────────────────────────────────────────────────────────────┐
│                    SECURITY CHECKS                                   │
├─────────────────────────────────────────────────────────────────────┤
│ ✓ Password lama verification dengan bcrypt                          │
│ ✓ Password baru minimum 8 characters                                │
│ ✓ Password confirmation validation                                  │
│ ✓ User authorization check (only own profile)                       │
│ ✓ CSRF protection on forms                                          │
│ ✓ Auth middleware on routes                                         │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 🔐 Password Strength Validator Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│              PASSWORD STRENGTH VALIDATION (Client-side)              │
└─────────────────────────────────────────────────────────────────────┘

User types in password field
        ↓
JavaScript event: onkeyup → checkPasswordStrength()
        ↓
Calculate strength score:
├─ >= 8 chars     → +20 points
├─ >= 12 chars    → +20 points
├─ Contains [a-z] → +20 points
├─ Contains [A-Z] → +20 points
├─ Contains [0-9] → +10 points
└─ Contains symbols → +10 points
        ↓
Score cap at 100%
        ↓
Display indicator:
├─ Score < 40   → 🔴 Lemah (red)
├─ 40 <= Score < 70 → 🟡 Sedang (yellow)
└─ Score >= 70  → 🟢 Kuat (green)
        ↓
Bar width = score%
        ↓
Update in real-time as user types
```

---

## 👤 UUID Generation Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                    UUID AUTO-GENERATION                              │
└─────────────────────────────────────────────────────────────────────┘

User Registration Process
        ↓
Form Submission → RegisterController@storeRegisterBackend()
        ↓
Validate input data
        ↓
User::create($validatedData)
        ↓
Model boot() method triggered:
protected static function boot()
{
    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = Str::uuid();  // Generate UUID v4
        }
    });
}
        ↓
UUID Generated: 550e8400-e29b-41d4-a716-446655440000
        ↓
Insert to database with UUID
        ↓
User created successfully
        ↓

BENEFITS:
✓ Unique per user
✓ Not sequential (secure)
✓ Hard to guess/brute force
✓ Globally unique format (UUID v4)
✓ Auto-generated (no manual input)
```

---

## 📧 Email Sending Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                      EMAIL SENDING FLOW                              │
└─────────────────────────────────────────────────────────────────────┘

ForgotPasswordController@sendResetLink()
        ↓
Generate reset_token & expires_at
        ↓
Update user in database
        ↓
Prepare email data:
{
    'user' => $user,
    'resetToken' => $resetToken,
    'resetUrl' => '/backend/reset-password/{token}'
}
        ↓
Mail::send(
    'backend.v_emails.reset_password',
    $emailData,
    callback
)
        ↓
Render view with data
        ↓
SMTP Connection (via .env config)
├─ Host: smtp.gmail.com
├─ Port: 587 (TLS)
├─ From: trisnawisesa20@gmail.com
└─ Auth: App Password
        ↓
Send to user email (Gmail)
        ↓

ERROR HANDLING:
├─ If send fails → Catch exception
├─ Log error to storage/logs/laravel.log
└─ Still show success message to user (prevent leaking info)
        ↓
User receives email within minutes
        ↓
User can click link and reset password
```

---

## 🔄 Role-based Redirect After Change Password

```
┌─────────────────────────────────────────────────────────────────────┐
│              ROLE-BASED SMART REDIRECT                               │
└─────────────────────────────────────────────────────────────────────┘

After password changed successfully:

$user->role == 0 (User)
    └─ route('backend.beranda.user')
       → /backend/user/beranda

$user->role == 1 (Admin)
    └─ route('backend.user.showUser')
       → /backend/admin/user

$user->role == 2 (Petugas)
    └─ route('backend.petugas.dashboard')
       → /backend/petugas/dashboard

No need to manually specify redirect!
System automatically determines based on user role.
```

---

## 📱 Error Handling Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                   ERROR HANDLING SCENARIOS                           │
└─────────────────────────────────────────────────────────────────────┘

SCENARIO 1: Invalid Reset Token
├─ What: User click wrong/expired token link
├─ Check: WHERE reset_token = ? AND reset_token_expires_at > NOW()
├─ Result: No matching user found
└─ Response: Redirect to login + error message

SCENARIO 2: Password Lama Salah
├─ What: User input wrong old password
├─ Check: Hash::check($input, $user->password)
├─ Result: Hash check fails
└─ Response: Show form + error: "Password lama tidak sesuai"

SCENARIO 3: Email Tidak Terdaftar
├─ What: User request reset untuk email yang tidak ada
├─ Check: WHERE email = ?
├─ Result: No user found
└─ Response: Still show success message (security)

SCENARIO 4: User Not Found
├─ What: Change password untuk id yang tidak ada
├─ Check: WHERE id_user = ?
├─ Result: No user found
└─ Response: Redirect back + error: "User tidak ditemukan"

SCENARIO 5: Email Send Failure
├─ What: SMTP connection failed
├─ Check: try-catch block
├─ Result: Exception caught
├─ Action: Log to storage/logs/laravel.log
└─ Response: Still show success (user won't know)
```

---

## ✅ Success Scenarios

```
SCENARIO 1: Successful Forgot Password Reset
├─ Email found ✓
├─ Reset token generated ✓
├─ Email sent ✓
├─ User clicks link ✓
├─ Token valid ✓
├─ New password set ✓
└─ User login dengan password baru ✓

SCENARIO 2: Successful Change Password
├─ User on profile page ✓
├─ Click "Ganti Password" ✓
├─ Form loaded ✓
├─ Input old password (correct) ✓
├─ Password verification pass ✓
├─ Input new password ✓
├─ Password updated ✓
└─ Redirect to dashboard ✓

SCENARIO 3: Successful UUID Generation
├─ User register ✓
├─ UUID generated ✓
├─ UUID stored in database ✓
├─ UUID unique ✓
└─ Can use for queries ✓
```

---

Dokumentasi Flow ini dirancang untuk memudahkan developer memahami alur setiap fitur.
Untuk implementasi detail, lihat folder: `app/Http/Controllers/ForgotPasswordController.php`
