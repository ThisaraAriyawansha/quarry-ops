# QuarryOps

A simple, user-friendly Point of Sale + Employee + Attendance + Payroll system built for stone quarry businesses (sand, rock, gravel, etc). Built with Laravel + MySQL. Designed to be easy to use for people with no IT/computer background.

Features:
- POS - sell products (sand, rock, gravel, any product you add)
- Employee registration
- Attendance marking (works with RFID attendance machines via ADMS push, see notes below)
- Salary / payroll calculation from attendance
- Role & Permission management (create roles, assign permissions, assign roles to users)
- Sinhala + English language switch
- Simple white/black theme, Poppins / Prata / Milonga fonts

---

## IMPORTANT - Setup Steps (do this in order)

This zip contains the **application code only** (models, migrations, seeders, controllers, views, routes). It is NOT a full Laravel installation by itself — you must first create a blank Laravel project on your own machine (this needs an internet connection to download Laravel + packages via Composer), then copy these files into it.

### Step 1 - Create a fresh Laravel project
```bash
composer create-project laravel/laravel QuarryOps
cd QuarryOps
```

### Step 2 - Install required packages
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### Step 3 - Copy the files from this zip into your project
Copy these folders/files from the zip **into** your new `QuarryOps` project, overwriting when asked:
- `database/migrations/*` → into your project's `database/migrations/`
- `database/seeders/*` → into your project's `database/seeders/`
- `app/Models/*` → into your project's `app/Models/`
- `app/Http/Controllers/*` → into your project's `app/Http/Controllers/`
- `routes/web.php` → replace your project's `routes/web.php`
- `resources/views/*` → into your project's `resources/views/`
- `resources/lang/en.json` and `resources/lang/si.json` → into your project's `resources/lang/` folder (create the `lang` folder if it doesn't exist)
- `public/css/app.css` → into your project's `public/css/`
- `config/permission.php` → replace the one created in Step 2 (optional, ours is the same standard config)

### Step 3.5 - Register the language-switch middleware
Open your project's `bootstrap/app.php` and add the `SetLocale` middleware to the web group:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
    ]);
})
```

### Step 4 - Set up your database
Edit `.env` in your project root:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quarryops
DB_USERNAME=root
DB_PASSWORD=your_password
```
Create the database:
```sql
CREATE DATABASE quarryops;
```

### Step 5 - Run migrations and seed demo data
```bash
php artisan migrate
php artisan db:seed
```

### Step 6 - Run the app
```bash
php artisan serve
```
Visit: `http://127.0.0.1:8000`

---

## Demo Login (created by the seeder)

| Role | Email | Password |
|---|---|---|
| Admin (full access) | admin@quarryops.com | password |
| Cashier (POS only) | cashier@quarryops.com | password |

**Change these passwords before giving this to the real client.**

---

## Demo Data Included (from seeders)
- 3 roles: Admin, Manager, Cashier — each with different permissions
- Sample products: River Sand, Quarry Dust, Metal 3/4", Metal 1/2", Rubble
- 2 demo employees
- Sample attendance + a calculated payroll example

---

## Connecting your RFID attendance machine later
The `attendances` table and `Attendance` model are already built to receive punches. When you get your RFID machine and confirm it supports ADMS/push, add the `tanemrahman/zkteco-adms` package and map its `user_id` to the `employees.device_user_id` column (already included in the migration) — ask me for that integration code when you're ready, it plugs straight into this structure.

## Sinhala / English language switch
Language files are in `resources/lang/en.json` and `resources/lang/si.json` (Laravel's JSON translation format — matches the `__('Some Text')` calls used throughout the views). A language switch link is in the top navbar. Add more phrases to both files as you build out more screens — just keep the exact same English key in both files, with the Sinhala translation as the value in `si.json`.

## Roles & Permissions
Go to **Settings → Roles** (Admin only) to create new roles and tick which permissions they should have. Go to **Settings → Users** to assign a role to any user. No code changes needed to add a new role.
