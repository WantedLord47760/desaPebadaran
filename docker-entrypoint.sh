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

# Automatic Railway MySQL Environment Variable Auto-detection
if [ -n "$MYSQL_URL" ] && ! echo "$MYSQL_URL" | grep -q '\${'; then
    export DATABASE_URL="$MYSQL_URL"
fi

if [ -z "$DB_HOST" ] || echo "$DB_HOST" | grep -q '\${'; then
    if [ -n "$MYSQLHOST" ] && ! echo "$MYSQLHOST" | grep -q '\${'; then
        export DB_HOST="$MYSQLHOST"
    elif [ -n "$RAILWAY_PRIVATE_DOMAIN" ]; then
        export DB_HOST="$RAILWAY_PRIVATE_DOMAIN"
    fi
fi

if [ -z "$DB_PORT" ] || echo "$DB_PORT" | grep -q '\${'; then
    if [ -n "$MYSQLPORT" ]; then
        export DB_PORT="$MYSQLPORT"
    fi
fi

if [ -z "$DB_DATABASE" ] || echo "$DB_DATABASE" | grep -q '\${'; then
    if [ -n "$MYSQLDATABASE" ]; then
        export DB_DATABASE="$MYSQLDATABASE"
    elif [ -n "$MYSQL_DATABASE" ]; then
        export DB_DATABASE="$MYSQL_DATABASE"
    fi
fi

if [ -z "$DB_USERNAME" ] || echo "$DB_USERNAME" | grep -q '\${'; then
    if [ -n "$MYSQLUSER" ]; then
        export DB_USERNAME="$MYSQLUSER"
    fi
fi

if [ -z "$DB_PASSWORD" ] || echo "$DB_PASSWORD" | grep -q '\${'; then
    if [ -n "$MYSQLPASSWORD" ]; then
        export DB_PASSWORD="$MYSQLPASSWORD"
    elif [ -n "$MYSQL_ROOT_PASSWORD" ]; then
        export DB_PASSWORD="$MYSQL_ROOT_PASSWORD"
    fi
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

echo "--- Starting Application via Supervisord on port $PORT ---"
exec supervisord -c /etc/supervisord.conf
