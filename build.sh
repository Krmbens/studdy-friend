#!/usr/bin/env bash
set -e

echo "🚀 Starting deployment build process..."

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies
echo "📦 Installing NPM dependencies..."
npm ci

# Build assets
echo "🎨 Building frontend assets..."
npm run build

# Create SQLite database
echo "💾 Setting up SQLite database..."
mkdir -p database
touch database/database.sqlite
chmod 664 database/database.sqlite

# Create storage directories
echo "📁 Creating storage directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Cache configuration
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"
