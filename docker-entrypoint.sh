#!/bin/bash
set -e

# Sesuaikan port jika provider cloud (seperti Render) memberikan $PORT
if [ -n "$PORT" ]; then
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/:80/:$PORT/g" /etc/apache2/sites-available/000-default.conf
fi

# Buat symbolic link storage
php artisan storage:link || true

# Jalankan migrasi dan seeder otomatis ke database
php artisan migrate --force || true
php artisan db:seed --force || true

# Set permission storage & cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan Apache
exec apache2-foreground

