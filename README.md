# 🏫 Sistem Informasi Pondok Pesantren Darul Ulum

Aplikasi berbasis **Laravel 12** untuk mengelola proses **pendaftaran santri, administrasi, dan dashboard admin** pada Pondok Pesantren Darul Ulum.

Aplikasi ini dirancang **siap produksi** dan menerapkan **role-based access control (RBAC)** dengan dua peran utama: **Admin** dan **Santri**.

---

## ✨ Fitur Utama

### 👤 Autentikasi

-   Login & Register
-   Logout
-   Forgot Password & Reset Password
-   Validasi form dengan pesan error Bahasa Indonesia

### 🧑‍🎓 Santri

-   Login santri
-   Halaman home santri
-   Halaman profil
-   Pendaftaran santri (Calon Santri)
-   Informasi status pendaftaran (Pending, Diterima, Ditolak)
-   Pembayaran
-   Print rapot _(hanya jika SPP Bulanan lunas)_

### 🛠️ Admin

-   Dashboard Admin
-   Manajemen data santri
-   Pembayaran
-   Rapot
-   Manajemen akun

### 🔐 Keamanan

-   Middleware `auth`
-   Middleware `role` (Admin / Santri)
-   Proteksi route berbasis role

---

## 🗂️ Struktur Folder (Views)

```
resources/views
│
├── layouts
│   ├── app.blade.php
│   └── dashboard.blade.php
│
├── partials
│   └── dashboard
│       ├── sidebar.blade.php
│       └── navbar.blade.php
│
├── pages
│   ├── auth
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   ├── forgot-password.blade.php
│   │   └── reset-password.blade.php
│   │
│   ├── dashboard
│   │   ├── index.blade.php
│   │   ├── santri.blade.php
│   │   └── pembayaran.blade.php
│   │
│   ├── profile
│   │   └── index.blade.php
│   │
│   └── landing.blade.php
```

---

## 🧭 Struktur Routing

### Public Route

-   `/` → Landing Page
-   `/auth/login`
-   `/auth/register`
-   `/auth/forgot-password`

### Santri (Login Required)

-   `/home`
-   `/pendaftaran`
-   `/profile`

### Admin (Login + Role Admin)

-   `/dashboard` → `dashboard.index`
-   `/dashboard/santri` → `dashboard.santri.index`

---

## 🧠 Penamaan Route (Best Practice)

Menggunakan **route name prefix**:

```php
Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');
    });
```

Contoh penggunaan di Blade:

```blade
<a href="{{ route('dashboard.index') }}">Dashboard</a>
```

---

## 🧱 Middleware

### Auth Middleware

Digunakan untuk memastikan user sudah login.

### Role Middleware

Digunakan untuk membatasi akses berdasarkan role user.

```php
if (auth()->user()->role !== $role) {
    abort(403);
}
```

---

## ⚙️ Teknologi yang Digunakan

-   Laravel 12
-   PHP 8.2
-   Blade Template Engine
-   Tailwind CSS
-   Alpine.js
-   MySQL

---

## 🚀 Cara Menjalankan Project

```bash
git clone https://github.com/almasrzld/project_pondok.git
cd project_pondok
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve/composer run dev
```

Akses aplikasi di:

```
http://127.0.0.1:8000
```

## ⚠️ PENTING! (WAJIB SETELAH RUN SISTEM)

Admin **WAJIB** membuat 2 jenis pembayaran:

1. **Daftar Ulang**
2. **SPP Bulanan**

SPP Bulanan menjadi syarat **cetak rapot**.

---

## 👥 Akun Default (Seeder)

### Admin

-   Email: `*****@*********.**`
-   Password: `************`

### Santri

-   Register melalui halaman register

---

## 📌 Catatan Pengembangan

-   Struktur route & view sudah scalable
-   Mudah ditambah fitur CRUD
-   Siap dikembangkan ke sistem pembayaran & akademik

---

## 📄 Lisensi

Project ini dibuat untuk keperluan internal Pondok Pesantren Darul Ulum.

---

💡 _Dikembangkan dengan Laravel Best Practice & struktur rapi agar mudah dikembangkan ke tahap produksi._
