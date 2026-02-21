#!/bin/sh
set -e

# Start SSH service
service ssh start

# Run Laravel migrations automatically on startup
php artisan migrate --force || true

# Start Apache in the foreground
apache2-foreground
