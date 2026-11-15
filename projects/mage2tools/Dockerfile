
FROM php:8.3-fpm

ENV DEBIAN_FRONTEND=noninteractive
ENV TERM=xterm-256color

# ============================================================
# Dependências do sistema
# ============================================================
RUN apt update && apt install -y \
    bash \
    bash-completion \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libxslt1-dev \
    libcurl4-openssl-dev \
    libsodium-dev \
    libgmp-dev \
    zip \
    vim \
    htop \
    dnsutils \
    procps \
    iputils-ping \
    net-tools \
    coreutils \
    && rm -rf /var/lib/apt/lists/*

# ============================================================
# Configurar GD do PHP
# ============================================================
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# ============================================================
# Extensões necessárias para Magento 2
# ============================================================
RUN docker-php-ext-install \
    bcmath \
    ftp \
    pdo \
    pdo_mysql \
    mysqli \
    intl \
    zip \
    gd \
    soap \
    xsl \
    opcache \
    sockets \
    sodium \
    exif \
    pcntl \
    gmp

# ============================================================
# Extensão do Redis para comunicação com Valkey
# ============================================================
RUN pecl install redis \
    && docker-php-ext-enable redis

# ============================================================
# Ajustar os limites do PHP
# ============================================================
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "upload_max_filesize=2G" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "post_max_size=2200M" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "max_execution_time=1800" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini

# ============================================================
# Criar o usuário e grupo do Magento 2
# ============================================================
RUN groupadd -g 1003 magentogroup \
    && useradd -u 1003 \
        -g magentogroup \
        -m \
        -s /bin/bash \
        magentouser

# ============================================================
# Configurar o terminal, aliases e prompt
# ============================================================
RUN echo "export TERM=xterm-256color" >> /home/magentouser/.bashrc \
    && echo "export CLICOLOR=1" >> /home/magentouser/.bashrc \
    && echo "alias ll='ls -lah --color=auto'" >> /home/magentouser/.bashrc \
    && echo "alias ls='ls --color=auto'" >> /home/magentouser/.bashrc \
    && echo "alias mag='php bin/magento'" >> /home/magentouser/.bashrc \
    && echo "alias magc='php bin/magento cache:clean'" >> /home/magentouser/.bashrc \
    && echo "alias magf='php bin/magento cache:flush'" >> /home/magentouser/.bashrc \
    && echo "alias magr='php bin/magento indexer:reindex'" >> /home/magentouser/.bashrc \
    && echo "PS1='\\[\\033[01;32m\\]\\u@\\h:\\w \\$\\[\\033[00m\\] '" >> /home/magentouser/.bashrc

# ============================================================
# Permissões do Magento 2
# ============================================================
RUN chown -R magentouser:magentogroup /var/www/html \
    && chown -R magentouser:magentogroup /home/magentouser

# ============================================================
# Instalar o Composer
# ============================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ============================================================
# Ambiente do Magento 2
# ============================================================
WORKDIR /var/www/html

# Usuário padrão do container
USER magentouser

# Shell padrão
SHELL ["/bin/bash", "-c"]

