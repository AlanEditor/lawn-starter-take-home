#!/bin/bash

echo "========================================"
echo " 🚀 Starting SWAPI Take-Home environment..."
echo "========================================"

# Copy .env if it doesn't exist
if [ ! -f "./api/.env" ]; then
  echo "📄 Copying .env file..."
  cp ./api/.env.example ./api/.env
else
  echo "📄 .env already exists, skipping..."
fi

echo "📦 Starting Docker containers..."
docker compose up -d --build

echo "🔧 Installing Laravel dependencies..."
docker exec swapi-php composer install --prefer-dist --no-interaction

echo "🔑 Generating APP_KEY..."
docker exec swapi-php php artisan key:generate

echo "🗄️ Running migrations..."
docker exec swapi-php php artisan migrate --force

echo "📊 Starting queue workers and scheduler (already automatic in containers)"
echo ""

echo "========================================"
echo " ✅ Environment started successfully!"
echo " Frontend: http://localhost:5173"
echo " Backend:  http://localhost:8080"
echo "========================================"
