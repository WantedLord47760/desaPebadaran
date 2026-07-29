#!/bin/sh
set -e

# Default PORT to 80 if not set
export PORT=${PORT:-80}

# Clean any existing conf.d / http.d defaults to prevent conflict
rm -rf /etc/nginx/conf.d/* /etc/nginx/http.d/*

# Substitute $PORT into full standalone /etc/nginx/nginx.conf
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Fallback APP_URL if empty or malformed
if [ -z "$APP_URL" ] || [ "$APP_URL" = "https://" ] || [ "$APP_URL" = "http://" ]; then
    export APP_URL="http://localhost"
fi

# Fallback DB_HOST if empty
if [ -z "$DB_HOST" ]; then
    export DB_HOST="${MYSQLHOST:-mysql.railway.internal}"
fi

echo "--- Preparing Laravel Application ---"

# Package discovery & Create storage symlink
php artisan package:discover --ansi || true
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
