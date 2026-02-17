#!/usr/bin/env bash

echo "🚀 Starting application server..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
