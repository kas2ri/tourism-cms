# AGENT.MD: Kiyara Holidays - Laravel CMS & Travel Platform

This document serves as the single source of truth for developing, maintaining, and deploying the **Kiyara Holidays** boutique travel web platform using **Laravel 11+**, **Blade**, **Tailwind CSS**, and an **Admin CMS** (Filament v3 or custom Blade/Tailwind admin dashboard).

---

## 1. Project Overview & Vision

- **Brand Name:** Kiyara Holidays (Pvt) Ltd.
- **Brand Identity:** Boutique, slow, and experiential luxury travel operator based in Sri Lanka (inspired by organic high-touch portals like WanaWander).
- **Core Technology Stack:**
  - **Framework:** PHP 8.2+ / Laravel 11.x
  - **Frontend:** Laravel Blade, Tailwind CSS, Alpine.js (or vanilla modern JS), FontAwesome 6 icons.
  - **Fonts:** *Cormorant Garamond* (Serif Editorial) & *Plus Jakarta Sans* (Body/UI Sans).
  - **Database:** MySQL 8.0+ or PostgreSQL 15+.
  - **Admin / CMS Engine:** Filament PHP v3 (recommended for rapid, high-security, reactive CMS) or clean Custom Laravel Blade Admin with Spatie Permissions.
  - **Media Management:** Spatie Laravel MediaLibrary or Laravel Storage disk (`public` / S3).
  - **Mailing & Notifications:** Laravel Queued Mailables + WhatsApp Webhook/Click-to-chat integration.

---

## 2. Architecture & Design Principles

1. **Aesthetic Consistency:**
   - Palette: Deep Forest (`#1a3b32`), Terracotta (`#c86d51`), Sand Warm Neutral (`#f4efe6` / `#fbf9f5`), Gold accents (`#d4af37`).
   - The public layout must replicate the single-page prototype experience while supporting SEO-friendly dynamic package URLs (`/packages/{slug}`).
2. **CMS First (Zero Hardcoded Content):**
   - All hero banners, testimonials, insider guides, micro-experiences, packages, itineraries, FAQs, and contact links must be fully editable by the administrator.
3. **Responsive & Mobile-Centric:**
   - Flawless experience on mobile, tablet, and desktop with off-canvas menus, sticky CTAs, and quick WhatsApp dispatch.
4. **Interactive Estimator & Multi-Currency Engine:**
   - Exchange rates stored in DB or cached with external rate API (e.g., ExchangeRate-API) with default fallback rates.

---

## 3. Database Schema Specification

### 3.1. Core System & Auth
- `users`: Standard Laravel authentication table (`id`, `name`, `email`, `password`, `role` [admin, editor], `remember_token`, timestamps).

### 3.2. Tour Packages & Itineraries
- `categories`:
  - `id` (bigint, pk)
  - `name` (string: "Small Group", "Bespoke Private", "Wellness & Nature", etc.)
  - `slug` (string, unique)
  - `description` (text, nullable)
  - `is_active` (boolean, default true)
  - timestamps

- `packages`:
  - `id` (bigint, pk)
  - `category_id` (foreign key -> categories.id)
  - `title` (string)
  - `slug` (string, unique)
  - `subtitle` / `tagline` (string, e.g. "Bestseller • Max 10 Guests")
  - `hero_image` (string/path)
  - `duration_days` (integer)
  - `duration_nights` (integer)
  - `starting_price_usd` (decimal: 10,2)
  - `region_tags` (json: e.g. `["Cultural Triangle", "Ella", "Yala"]`)
  - `travel_style` (enum: `group`, `bespoke`, `wellness`, `slow`)
  - `short_summary` (text)
  - `full_description` (longText)
  - `inclusions` (json array of strings)
  - `exclusions` (json array of strings)
  - `max_travelers` (integer, default 12)
  - `featured` (boolean, default false)
  - `is_active` (boolean, default true)
  - `order` (integer, default 0)
  - timestamps

- `itinerary_days`:
  - `id` (bigint, pk)
  - `package_id` (foreign key -> packages.id, cascade delete)
  - `day_number` (integer, e.g., 1, 2 or range)
  - `title` (string, e.g. "Day 1-2: Negombo & The Cultural Triangle")
  - `description` (text)
  - `stay_location` (string, nullable)
  - `image` (string, nullable)
  - timestamps

### 3.3. Content & Experience Management
- `experiences`:
  - `id` (bigint, pk)
  - `title` (string, e.g. "Village Claypot Feast with Amma Lakshmi")
  - `category_badge` (string, e.g. "Culinary Heritage")
  - `summary` (text)
  - `image` (string)
  - `order` (integer, default 0)
  - `is_active` (boolean, default true)
  - timestamps

- `team_insiders`:
  - `id` (bigint, pk)
  - `name` (string, e.g. "Rohan Jayawardena")
  - `role_title` (string, e.g. "Driver Storyteller • 14 Years Guiding")
  - `speciality` (string, e.g. "Cultural Triangle & Hill Country Flora")
  - `quote_bio` (text)
  - `avatar` (string)
  - `order` (integer, default 0)
  - `is_active` (boolean, default true)
  - timestamps

- `reviews`:
  - `id` (bigint, pk)
  - `author_name` (string)
  - `location_country` (string, e.g. "Melbourne, Australia")
  - `trip_type` (string, e.g. "Small Group Trip")
  - `headline` (string, e.g. "The antithesis of commercial tourism")
  - `review_text` (text)
  - `rating` (smallint, default 5)
  - `avatar_initials` (string, nullable)
  - `avatar_image` (string, nullable)
  - `is_featured` (boolean, default true)
  - timestamps

### 3.4. Lead Captures & Inquiries
- `inquiries`:
  - `id` (bigint, pk)
  - `full_name` (string)
  - `email` (string)
  - `phone_whatsapp` (string, nullable)
  - `package_id` (foreign key -> packages.id, nullable)
  - `travel_dates` (string, nullable)
  - `travelers_count` (integer, default 2)
  - `travel_style` (string, nullable)
  - `notes` (text, nullable)
  - `source` (string, default "general_modal" / "estimator" / "whatsapp")
  - `status` (enum: `new`, `contacted`, `converted`, `archived`)
  - timestamps

- `lead_downloads`:
  - `id` (bigint, pk)
  - `email` (string)
  - `first_name` (string, nullable)
  - `guide_title` (string, default "Secret Ceylon Guide 2025")
  - `downloaded_at` (timestamp)
  - timestamps

- `site_settings`:
  - Key-value store (`key` unique string, `value` text/json, `group` string) for site phones, WhatsApp direct links, banner slogans, currency exchange manual overrides.

---

## 4. Application Routes Structure

```php
// routes/web.php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\GuideDownloadController;

// Public Website
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/packages', [FrontendController::class, 'packages'])->name('packages.index');
Route::get('/packages/{slug}', [FrontendController::class, 'showPackage'])->name('packages.show');
Route::get('/experiences', [FrontendController::class, 'experiences'])->name('experiences.index');

// Lead Captures & AJAX Submissions
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::post('/download-guide', [GuideDownloadController::class, 'store'])->name('guide.download');
Route::get('/api/exchange-rates', [FrontendController::class, 'getRates'])->name('api.rates');

// Admin Panel Routes (If not using Filament)
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('packages', Admin\PackageController::class);
    Route::resource('experiences', Admin\ExperienceController::class);
    Route::resource('insiders', Admin\InsiderController::class);
    Route::resource('reviews', Admin\ReviewController::class);
    Route::resource('inquiries', Admin\InquiryController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('admin.settings.edit');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
```

---

## 5. Directory & Blade Layout Structure

```
resources/
├── css/
│   └── app.css                 # Tailwind directives + custom font styling
├── js/
│   ├── app.js                  # Currency switcher, estimator Alpine data, modals
│   └── estimator.js            # Live cost formula calculations
└── views/
    ├── layouts/
    │   ├── app.blade.php       # Main Public Layout (Navbar, Toast, Floating WA, Footer)
    │   └── admin.blade.php     # Admin CMS Layout (Sidebar, Topbar, Alerts)
    ├── components/
    │   ├── navbar.blade.php
    │   ├── footer.blade.php
    │   ├── hero.blade.php
    │   ├── tour-card.blade.php
    │   ├── currency-selector.blade.php
    │   ├── cost-estimator.blade.php
    │   ├── experience-card.blade.php
    │   ├── review-card.blade.php
    │   ├── modals/
    │   │   ├── inquiry-modal.blade.php
    │   │   ├── itinerary-modal.blade.php
    │   │   ├── guide-modal.blade.php
    │   │   └── insiders-modal.blade.php
    │   └── toast.blade.php
    ├── pages/
    │   ├── home.blade.php      # Compiles the sections seamlessly from the prototype
    │   ├── packages/
    │   │   ├── index.blade.php
    │   │   └── show.blade.php  # Detailed view per package with rich schema markup
    └── admin/
        ├── dashboard.blade.php
        ├── packages/           # Create, Edit, List with day-by-day repeater
        ├── inquiries/          # CRM style leads board
        └── settings.blade.php
```

---

## 6. Admin Panel / CMS Strategy

### Option A: Filament PHP v3 (Fastest & Highly Recommended)
- Install Filament v3 via `composer require filament/filament:"^3.2"`.
- Use **Filament Resources** for `PackageResource`, `ExperienceResource`, `ReviewResource`, `TeamInsiderResource`, and `InquiryResource`.
- Features built-in:
  - File upload with image previews and responsive thumbnail generation.
  - Repeater component for `itinerary_days` within the Package form.
  - Rich text editor for package descriptions.
  - Role-based login and password recovery.

### Option B: Custom Blade Admin Dashboard
- Clean, bespoke Tailwind admin layout matching the luxury forest-green palette.
- Form requests with full CSRF protection, file upload validation, and soft deletes.

---

## 7. Interactive Frontend Features to Retain from Prototype

1. **Multi-Currency System:**
   - Default: `USD ($)`. Supported: `EUR (€)`, `GBP (£)`, `AUD (A$)`.
   - Store prices in USD in the database, calculate frontend prices dynamically via client-side Alpine store or cached exchange rates.
2. **Interactive Trip Builder & Cost Estimator:**
   - Sliders for duration (5 - 21 days), buttons for travel party type, and accommodation tiers.
   - Live estimated calculation card connected to the inquiry modal.
3. **Modals & Drawers:**
   - Dynamic itinerary preview drawer without reloading the page.
   - Lead magnet popup for downloading the "Secret Ceylon" PDF Guide.
   - WhatsApp concierge widget with simulated live support.

---

## 8. Step-by-Step Implementation Checklist for Antigravity

- [ ] **Step 1: Environment Setup**
  - Run `composer create-project laravel/laravel kiyara-holidays`
  - Configure `.env` (`DB_DATABASE`, `APP_URL`, Mail credentials, `FILESYSTEM_DISK=public`)
  - Run `php artisan storage:link`
- [ ] **Step 2: Frontend & Tailwind Scaffolding**
  - Install Tailwind CSS via Vite: `npm install -D tailwindcss postcss autoprefixer && npx tailwindcss init -p`
  - Configure `tailwind.config.js` with Kiyara branding colors (`forest`, `terracotta`, `sand`) and Google Fonts.
- [ ] **Step 3: Database Migrations & Seeders**
  - Create migrations for `categories`, `packages`, `itinerary_days`, `experiences`, `team_insiders`, `reviews`, `inquiries`, `lead_downloads`.
  - Create a realistic database seeder (`KiyaraDatabaseSeeder.php`) populated with the exact content from the HTML prototype.
- [ ] **Step 4: Models & Relationships**
  - Set up `Package` model with `hasMany(ItineraryDay::class)` and `belongsTo(Category::class)`.
  - Set up scopes: `scopeActive()`, `scopeFeatured()`.
- [ ] **Step 5: Admin CMS Setup**
  - Scaffold Filament or create custom admin controllers and views.
  - Ensure image uploads store files properly to `storage/app/public/packages/`.
- [ ] **Step 6: Public Views & Controller Assembly**
  - Migrate the prototype HTML sections into Blade components (`resources/views/components/*`).
  - Connect database queries in `FrontendController@index` to load packages, reviews, and insiders dynamically.
- [ ] **Step 7: Form Processing & Lead Notifications**
  - Wire up `/inquiry` form submission with validation and email notification to `hello@kiyaraholidays.com`.
  - Wire up `/download-guide` with automatic queue dispatch for email delivery.
- [ ] **Step 8: Testing & Polish**
  - Test responsive navigation on mobile viewports.
  - Verify currency switcher changes all rendered price elements.
  - Run `npm run build` and ensure Vite assets are optimized.

---

## 9. Antigravity Agent Directives

- **Voice & Tone:** Premium, authentic, culturally respectful, evocative of Sri Lanka's wild and heritage beauty.
- **Code Quality:** Strict PSR-12 coding standard, explicit type hints in PHP 8.2+, sanitized Blade output (`{{ $package->title }}`), CSRF tokens on all forms, and SEO meta tags with OpenGraph previews.
- **Modularity:** Keep controllers thin; extract lead-capturing and rate-calculating logic into dedicated Service classes (`PackageService`, `InquiryService`, `CurrencyService`).