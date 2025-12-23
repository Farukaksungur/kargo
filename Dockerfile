# Render için optimize edilmiş Dockerfile
FROM php:8.4-cli

# Sistem bağımlılıklarını yükleyelim
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Composer'ı yükleyelim
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel için gerekli PHP uzantılarını yükleyelim
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pdo_sqlite zip

# Çalışma dizinini ayarla
WORKDIR /var/www

# Proje dosyalarını kopyala
COPY . .

# Bağımlılıkları yükle
RUN composer install --no-dev --optimize-autoloader --no-interaction

# SQLite database oluştur
RUN mkdir -p database && touch database/database.sqlite && chmod 664 database/database.sqlite

# Storage ve cache klasörlerine yazma izni ver
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache || true

# APP_KEY oluştur (eğer yoksa)
RUN php artisan key:generate --force || true

# Laravel cache'leri oluştur (APP_KEY olmadan çalışmayabilir)
RUN php artisan config:cache || echo "Config cache skipped"
RUN php artisan route:cache || echo "Route cache skipped"
RUN php artisan view:cache || echo "View cache skipped"

# Migrations çalıştır
RUN php artisan migrate --force || echo "Migrations skipped"

# Storage link oluştur
RUN php artisan storage:link || echo "Storage link skipped"

# Port'u dinle
EXPOSE $PORT

# Render'ın PORT environment variable'ını kullan
CMD php artisan serve --host=0.0.0.0 --port=$PORT

