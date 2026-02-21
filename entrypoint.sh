#!/bin/sh
set -e

# Start SSH service
service ssh start

# Fix storage permissions at runtime
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run Laravel migrations automatically on startup
php artisan migrate --force || true

# Start Apache in the foreground
apache2-foreground
