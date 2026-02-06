# Multi-stage build para otimização

# Stage 1: Build dos assets frontend
FROM node:20-alpine AS frontend-builder

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY vite.config.js postcss.config.js tailwind.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# Stage 2: Build da aplicação PHP
FROM php:8.3-fpm-alpine AS php-builder

# Instalar dependências de build
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    oniguruma-dev \
    icu-dev

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar apenas arquivos necessários para composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Stage 3: Imagem final de produção
FROM php:8.3-fpm-alpine

# Labels para metadata
LABEL org.opencontainers.image.title="Apostolado da Oração"
LABEL org.opencontainers.image.description="Sistema de gerenciamento para o Apostolado da Oração em Português do Brasil"
LABEL org.opencontainers.image.vendor="Apostolado da Oração"
LABEL org.opencontainers.image.licenses="MIT"

# Instalar apenas dependências de runtime
RUN apk add --no-cache \
    bash \
    curl \
    libpng \
    libjpeg-turbo \
    libwebp \
    freetype \
    libzip \
    postgresql-libs \
    oniguruma \
    icu-libs \
    nginx \
    supervisor

# Copiar extensões PHP compiladas
COPY --from=php-builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php-builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Configuração PHP otimizada
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=16" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Criar usuário não-root
RUN addgroup -g 1000 laravel && adduser -D -u 1000 -G laravel laravel

WORKDIR /var/www/html

# Copiar vendor do builder
COPY --from=php-builder --chown=laravel:laravel /var/www/html/vendor ./vendor

# Copiar aplicação
COPY --chown=laravel:laravel . .

# Copiar assets buildados
COPY --from=frontend-builder --chown=laravel:laravel /app/public/build ./public/build

# Copiar configurações do Nginx e Supervisor
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configurar permissões
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R laravel:laravel storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && mkdir -p /tmp/nginx/{client_body,proxy,fastcgi,uwsgi,scgi} \
    && mkdir -p /tmp/supervisor \
    && chown -R laravel:laravel /tmp/nginx /tmp/supervisor

# Criar arquivo .env se não existir
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
    CMD curl -f http://localhost/health || exit 1

# Expor portas
EXPOSE 80

# Usar usuário não-root
USER laravel

# Comando de inicialização
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
