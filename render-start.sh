#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Run migrations on startup (optional, can be disabled)
# php artisan migrate --force

# Start the application
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

