# PHP 8.0 image kullan
FROM php:8.0-fpm

# Sistem bağımlılıklarını yükle
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git

# Composer'ı yükle
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Laravel için gerekli PHP uzantılarını yükle
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Çalışma dizinini ayarla
WORKDIR /var/www

# Uygulama dosyalarını kopyala
COPY . .

# Composer ile bağımlılıkları yükle
RUN composer install

# Apache veya Nginx ile servis çalıştırabiliriz, ancak Laravel için PHP-FPM ile çalışacağız
CMD ["php-fpm"]

# Varsayılan portu aç
EXPOSE 9000
