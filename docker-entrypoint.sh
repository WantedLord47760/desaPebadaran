#!/bin/sh
set -e

# Default PORT to 80 if not set
export PORT=${PORT:-80}

# Substitute $PORT in Nginx template
envsubst '${PORT}' < /etc/nginx/conf.d/default.template > /etc/nginx/conf.d/default.conf

echo "--- Preparing Laravel Application ---"

# Create storage symlink
php artisan storage:link --force || true

# Optimize & Cache Laravel
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "Running Database Migrations..."
php artisan migrate --force

# Run database seeder if SEED_ON_DEPLOY environment variable is set to true
if [ "$SEED_ON_DEPLOY" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

echo "--- Starting PHP-FPM & Nginx on port $PORT ---"
php-fpm -D
exec nginx -g "daemon off;"
