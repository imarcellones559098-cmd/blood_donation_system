#!/bin/sh
set -e

echo "============================================"
echo "  Blood Donation System — Starting Up"
echo "============================================"

# ── Storage & cache directories ───────────────────────────────────────────────
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/testing
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

cd /var/www/html

# ── Generate APP_KEY if not provided ─────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
    echo "[WARN] APP_KEY not set — generating one now..."
    php artisan key:generate --force
fi

# ── Cache configuration (production optimizations) ───────────────────────────
echo "[INFO] Caching config, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# ── Run database migrations ───────────────────────────────────────────────────
echo "[INFO] Running database migrations..."
php artisan migrate --force

# — Run database seeders ————————————————————————
echo "[INFO] Running database seeders..."
php artisan db:seed --force

# ── Create storage symlink ────────────────────────────────────────────────────
echo "[INFO] Creating storage symlink..."
php artisan storage:link || true

# ── Start supervisor (nginx + php-fpm) ────────────────────────────────────────
echo "[INFO] Starting services via supervisor..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
