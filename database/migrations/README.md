# ClinicOS Laravel 13 Migrations

Generated from `ClinicOS_43_Modules_Database_Schema.sql`.

- Laravel: 13.x
- Database: MySQL 8.0+
- Tables: 84
- Migration files: 84
- Foreign keys are included.
- Indexes and unique constraints from the canonical SQL are included.
- Migration filenames are sequentially ordered to respect FK dependencies.

## Installation

Copy the migration files into:

`database/migrations/`

Then run:

`php artisan migrate`

## Notes

The generated migrations intentionally preserve the canonical database design rather than relying on Laravel's default timestamp conventions.

Review environment-specific items such as database name, charset, SQL mode, and any future domain-specific enum changes before production deployment.
