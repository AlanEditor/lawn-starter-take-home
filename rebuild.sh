#!/bin/bash

echo "========================================"
echo " ♻️ Full rebuild..."
echo "========================================"

docker compose down -v

echo "🧹 Removing vendor folder from host..."
rm -rf ./api/vendor

echo "🧹 Removing node_modules from host..."
rm -rf ./frontend/node_modules

echo "🔨 Rebuilding containers..."
docker compose up -d --build

echo "📦 Installing Laravel dependencies..."
docker exec swapi-php composer install --prefer-dist --no-interaction

echo "🔑 Generating APP_KEY..."
docker exec swapi-php php artisan key:generate

echo "🗄️ Running migrations..."
docker exec swapi-php php artisan migrate --force

echo "========================================"
echo " ✅ Full rebuild completed!"
echo "========================================"
