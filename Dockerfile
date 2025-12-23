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

# Laravel cache'leri oluştur
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Migrations çalıştır (APP_KEY gerekebilir, bu yüzden || true)
RUN php artisan migrate --force || true

# Storage link oluştur
RUN php artisan storage:link || true

# Port'u dinle
EXPOSE $PORT

# Render'ın PORT environment variable'ını kullan
CMD php artisan serve --host=0.0.0.0 --port=$PORT

