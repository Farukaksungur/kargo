#!/bin/bash
set -e

echo "🚀 Starting Render build process..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Generate application key if not exists
echo "🔑 Generating application key..."
php artisan key:generate --force

# Cache configuration
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "✅ Build completed successfully!"

