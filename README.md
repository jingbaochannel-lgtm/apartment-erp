# Apartment ERP Management System

Laravel 12 ERP suite for running one or many apartment buildings. The project
ships a complete admin shell (Bootstrap 5 + Yajra DataTables + SweetAlert2 +
PHPFlasher + flatpickr + Tom Select) with bilingual UI (English / Khmer) that
switches without a page refresh, and a single migration that creates the full
schema (property owners, branches, buildings, floors, rooms, tenants, rental
contracts, utility metering, invoicing, payments, maintenance, inventory,
procurement, HR, payroll, accounting, ISO QMS, notifications, audit logs).

> Generated for `jingbaochannel-lgtm/apartment-erp`.

## Highlights

- **Multi-branch** – every operational table carries an `apartment_profile_id`
  and is filtered through a global `ApartmentScope` based on the active branch
  in the session. The header includes a branch switcher.
- **RBAC** – `system_roles`, `system_permissions`, `user_role`,
  `role_permission` tables wired up out of the box, plus a super-admin role
  seeded with every permission.
- **Audit logs** – the `Auditable` trait records create/update/delete events
  for every model into `audit_logs` (user, module, action, old/new values).
- **Soft deletes everywhere** – `deleted_by` + `deleted_at` are part of every
  table.
- **Generic CRUD** – one `BaseCrudController` + `_crud/index|form|show` Blade
  templates power every module. Field shape is declared as
  `CrudField` value objects on the concrete controller.
- **Server-side DataTables** – Yajra DataTables with Bootstrap 5 simple
  pagination is wired through `BaseCrudController::data()` and the generic
  index view.
- **Bilingual** – every label goes through `__('app.…')`. Switching uses
  `POST /language` (AJAX) or `GET /language/{locale}` and persists the choice
  in `session('locale')` + a 1-year cookie.

## Requirements

- PHP **8.2+**
- Composer 2.x
- SQLite (default) or MySQL/PostgreSQL

## Quick start

```bash
git clone https://github.com/jingbaochannel-lgtm/apartment-erp.git
cd apartment-erp

composer install
cp .env.example .env
php artisan key:generate

# SQLite (default)
touch database/database.sqlite

php artisan migrate --seed
php artisan serve
```

The seeders create:

| Resource           | Value                                                       |
|--------------------|-------------------------------------------------------------|
| Default branch     | `HQ` – Head Office (Phnom Penh)                             |
| Super-admin login  | `admin` / `password` (`admin@apartment-erp.local`)          |
| Roles              | super_admin, branch_manager, accountant, front_desk, maintenance_staff, tenant_user |
| Utility types      | Electricity, Water, Gas, Internet                           |

Visit <http://localhost:8000/admin> after starting the dev server.

## Project layout

```
app/
  Http/Controllers/Admin/         CRUD controllers + dashboard + apartment switcher
  Http/Controllers/LanguageController.php
  Http/Middleware/SetLocale.php
  Models/                         79 Eloquent models for the ERP schema
  Models/Concerns/                Auditable trait + helpers
  Models/Scopes/ApartmentScope.php
  Observers/AuditingObserver.php
  Support/                        CrudField + ColumnRenderer
database/
  migrations/2026_05_08_000000_create_apartment_erp_all_tables.php
  seeders/                        Idempotent seeders
resources/
  views/admin/                    admin_layout + admin_partials + dashboard
  views/admin/_crud/              Generic index / form / show templates
lang/
  en/app.php
  km/app.php
routes/
  web.php                         61 resource routes + language + apartment switch
scripts/
  controller_definitions.php      Source of truth for the 61 CRUD modules
  model_definitions.php
  generate_controllers.php
  generate_models.php
```

## Adding a new CRUD module

1. Add a new entry to `scripts/controller_definitions.php` (slug, model,
   singular/plural labels, columns, fields).
2. Run `php scripts/generate_controllers.php` to emit the controller +
   register the route.
3. Add a sidebar entry in
   `resources/views/admin/layouts/admin_partials/left_sidebar.blade.php`.
4. Add translation keys to `lang/en/app.php` and `lang/km/app.php`.

## Front-end stack

All assets are referenced from the layout partials and loaded from CDNs:

- **Bootstrap 5** + **Bootstrap Icons** (base theme)
- **jQuery 3.x** (DataTables + helpers)
- **Yajra DataTables** with Bootstrap 5 styling and `simple_numbers` pagination
- **SweetAlert2** – delete confirmation, generic confirms
- **PHPFlasher** – server-side flash messages rendered as toast notifications
- **flatpickr** – date / datetime fields, Khmer locale auto-applied when KH is
  active
- **Tom Select** – AJAX-capable select boxes

The plugin initializer lives in
`resources/views/admin/layouts/admin_partials/scripts.blade.php` as
`window.AppPlugins.init(root)`. CRUD templates call it after every dynamic
update.

## Language switching (no page reload)

```js
$.post('/language', { locale: 'km' }, function () {
    location.reload(); // or selectively replace translatable nodes
});
```

`SetLocale` middleware resolves the active locale from (in order)
`?locale=`, session, cookie, then `config('app.locale')`. The header includes
EN/KH options that POST to `language.set`.

## Tests / lint

```bash
composer dump-autoload -o
php artisan route:list           # 497 routes registered
php artisan migrate:fresh --seed # blank-slate verification
./vendor/bin/pint -v             # Laravel Pint (configured)
```

## License

MIT.
