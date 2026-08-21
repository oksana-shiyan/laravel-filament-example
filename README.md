# Catalog Demo

A small **Laravel 12 + Filament 5** client demo.

Visitors open `/`, sign in, land on a dashboard with stats cards, then manage products and categories.

## Demo credentials

| Field    | Value               |
|----------|---------------------|
| Email    | `admin@example.com` |
| Password | `password`          |

## Requirements

- Docker & Docker Compose
- Ports from `.env` (defaults: app on `81`, Postgres on `5435`)

## Setup

```bash
cp .env.example .env   # if needed; set APP_URL / COMPOSE_NGINX_PORT
docker compose up -d
docker compose exec php-fpm composer install
docker compose exec php-fpm php artisan key:generate   # if APP_KEY is empty
docker compose exec php-fpm php artisan migrate --seed
```

Open the app (for this env: [http://localhost:81](http://localhost:81)).

All PHP / Composer / Artisan / Pest commands run inside `php-fpm`:

```bash
docker compose exec php-fpm php artisan …
docker compose exec php-fpm composer …
docker compose exec php-fpm ./vendor/bin/pest
```

## What you can demo

**Dashboard (`/`)**
- Stats cards: products, low stock, categories, comments

**Products**
- CRUD list with search and filters (category, active, stock level)
- Stock badges: red (0) / amber (≤10) / green (11+)
- **Restock** row action — modal asks for a custom quantity
- Bulk **Mark inactive** and bulk delete
- Form sections: Basics, Pricing & inventory, Meta (key-value JSON), Comments (repeater)

**Categories**
- Simple name/slug CRUD; products can belong to a category

**Panel branding**
- Brand name “Catalog Demo”, teal theme, Catalog nav group, collapsible sidebar

## Seeded data

- Admin user (credentials above)
- 3 categories, 6 products (with `meta` where relevant), sample comments

## Tests

```bash
docker compose exec php-fpm php artisan test
```

## Stack

- Laravel 12, Filament 5, Livewire, Pest
- PostgreSQL via Docker
- Leftover Vue/npm packages in the repo are unused; the running app does not depend on them
