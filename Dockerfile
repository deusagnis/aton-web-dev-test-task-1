FROM php:7.4-fpm

# Аргументы для установки пользователя
ARG user
ARG uid

# Установка основных системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano-tiny

# Установка PHP расширений
RUN apt-get install -y libzip-dev && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка NodeJS
RUN curl -sL https://deb.nodesource.com/setup_18.x -o nodesource_setup.sh
RUN ["sh",  "./nodesource_setup.sh"]
RUN apt-get install nodejs -y

# Очистка кеша установочной утилиты
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Добавление Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка разрешений доступа к файлам
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www

# Установка рабочей директории
WORKDIR /var/www

USER $user