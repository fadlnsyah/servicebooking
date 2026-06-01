# ServiceBooking

ServiceBooking is a full-stack Laravel portfolio project for online service booking management. Customers can browse services, book appointments, track booking history, and manage reviews, while admins and providers can monitor schedules, manage operational data, and review reports from a modern dashboard.

## Features

- Public landing page with modern SaaS-style presentation
- Service catalog with search, filters, sorting, and service detail pages
- Auth flow with login, register, forgot password, and email verification
- Customer dashboard with upcoming bookings, booking history, reschedule, cancel, and review actions
- Booking workflow with booking summary, Indonesian Rupiah pricing, and generated booking codes
- Admin panel at `/admin` powered by Filament
- Booking, service, and category management in the admin area
- Admin customer and provider overview pages
- Calendar, reports, export, and settings pages
- Spatie role and permission setup for `admin`, `customer`, and `provider`
- Excel export and PDF report export
- Booking activity logging and seeded demo data

## Tech Stack

- Laravel 13
- PHP 8.4
- Blade templates
- Tailwind CSS
- Alpine.js
- Vite
- Filament
- Spatie Laravel Permission
- Maatwebsite Excel
- Barryvdh DomPDF
- MySQL or MariaDB for deployment

## Database Schema Overview

- `users`
  Includes `name`, `email`, `phone`, password fields, and Spatie roles.
- `categories`
  Stores service categories and display metadata.
- `services`
  Stores service catalog data, pricing in Rupiah, duration, provider relation, and ratings.
- `provider_profiles`
  Stores provider bio, contact, and availability notes.
- `bookings`
  Stores booking code, customer snapshot, schedule, price, payment, and status.
- `booking_activities`
  Stores booking timeline and status changes.
- `reviews`
  Stores post-service customer ratings and comments.
- `settings`
  Stores configurable business settings.
- Spatie permission tables
  Stores roles, permissions, and model mappings.

## Installation

1. Clone the repository.
2. Enter the project directory:

```bash
cd servicebooking
```

3. Install PHP dependencies:

```bash
composer install
```

4. Install frontend dependencies:

```bash
npm install
```

5. Copy the environment file:

```bash
cp .env.example .env
```

6. Generate the app key:

```bash
php artisan key:generate
```

7. Configure your database in `.env` for MySQL or MariaDB.

8. Run migrations and seeders:

```bash
php artisan migrate --seed
```

9. Start the development servers:

```bash
php artisan serve
npm run dev
```

## Environment Variables

Set these in `.env`:

- `APP_NAME=ServiceBooking`
- `APP_URL=http://localhost:8000`
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=servicebooking`
- `DB_USERNAME=your_username`
- `DB_PASSWORD=your_password`
- `MAIL_MAILER=log`
- `QUEUE_CONNECTION=database`
- `FILESYSTEM_DISK=public`

## Migrations and Seeders

Run:

```bash
php artisan migrate --seed
```

This creates:

- Roles and permissions
- Demo admin, customer, and provider accounts
- Service categories
- Demo services
- Sample bookings and booking activities
- Default business settings

## Demo Accounts

- Admin
  `admin@servicebooking.test` / `password`
- Customer
  `customer@servicebooking.test` / `password`
- Provider
  `provider@servicebooking.test` / `password`

## Routes Overview

- Public
  `/`
  `/services`
  `/services/{service:slug}`
- Customer
  `/dashboard`
  `/my-bookings`
- Admin
  `/admin`
  `/admin/bookings`
  `/admin/services`
  `/admin/categories`
  `/admin/customers`
  `/admin/providers`
  `/admin/calendar`
  `/admin/reports`
  `/admin/settings`

## Screenshots

Add portfolio screenshots here after running the app locally:

- Landing page
- Service catalog
- Booking workflow
- Customer dashboard
- Admin dashboard
- Reports page

## Folder Structure

- `app/`
  Application logic, models, services, policies, exports, mail, and Filament classes.
- `database/`
  Migrations, factories, and seeders.
- `resources/views/`
  Blade layouts, pages, components, auth screens, and export templates.
- `routes/`
  Public, auth, customer, and admin route definitions.
- `public/`
  Compiled assets and published Filament assets.

## Future Improvements

- Add provider-specific CRUD pages and richer provider scheduling tools
- Add FullCalendar-based interactive calendar UI
- Add image upload previews on public pages
- Add payment gateway integration
- Add queue-backed mail notifications and reminder jobs
- Add automated feature tests against a configured database
