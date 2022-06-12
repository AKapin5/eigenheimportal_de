## Installing:

```
composer install
cp .env.example env
php artisan storage:link
php artisan key:generate
php artisan ide-helper:generate
```

## After configuring DB_CONNECTION settings in .env run:
```
php artisan migrate
php artisan db:seed
```

## To regenerate image thumbs (needed when adding new image conversions) run:
```
php artisan media-library:regenerate --only-missing
```
