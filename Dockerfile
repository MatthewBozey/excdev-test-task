FROM php:8.3-fpm

# Установка необходимых пакетов, включая Node.js и npm
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    supervisor \
    gnupg2 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip gd exif pcntl bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Установка Node.js и npm
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html

# Копирование и установка зависимостей
COPY composer.json package.json ./
RUN composer install --no-autoloader --no-scripts --prefer-dist --no-dev
RUN npm install

# Копирование файлов приложения и сборка фронта
COPY . .
RUN npm run build
RUN composer dump-autoload --optimize

# Установка прав
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Настройка Supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./docker/supervisor/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# Открытие портов
EXPOSE 9000

# Запуск Supervisor для управления PHP-FPM и очередями
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
