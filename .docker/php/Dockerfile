FROM php:8.3-fpm AS base

LABEL org.opencontainers.image.source=https://github.com/davch/github-workflow-example

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libicu-dev \
    zip \
    unzip \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip intl opcache
RUN pecl install apcu && docker-php-ext-enable apcu

# Explicitly enable OPcache
RUN docker-php-ext-enable opcache

RUN pecl install redis && docker-php-ext-enable redis

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy custom php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# App stage
FROM base AS app
CMD ["symfony", "server:start", "--port=8383", "--no-tls"]

# CLI stage
FROM base AS cli

# Install additional CLI tools
RUN apt-get update && apt-get install -y \
    vim \
    wget \
    htop \
    iputils-ping \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

CMD ["/bin/bash"]