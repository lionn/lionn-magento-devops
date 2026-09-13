FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive
ENV TERM=xterm-256color

# Instalar as dependências do sistema e bash
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
    curl \
    vim \
    nano \
    htop \
    dnsutils \
    procps \
    iputils-ping \
    net-tools \
    coreutils \
    && rm -rf /var/lib/apt/lists/*

# Configurar GD do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instalar as extensões necessárias para o Magento 2
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

# Ajustar os limites do PHP
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "upload_max_filesize=2G" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "post_max_size=2200M" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini \
    && echo "max_execution_time=1800" >> /usr/local/etc/php/conf.d/zz-memory-limit.ini

# 1. Cria o grupo 'magentogroup' e o usuário 'magentouser' usando o ID 1001 (igual ao seu usuário adm do sistema Linux - NUNCA USAR O ROOT!)
RUN groupadd -g 1001 magentogroup && \
    useradd -u 1001 -g magentogroup -m -s /bin/bash magentouser

# 2. Configura o terminal com cores e aliases na home correta
RUN echo "export TERM=xterm-256color" >> /home/magentouser/.bashrc \
    && echo "alias ll='ls -lah --color=auto'" >> /home/magentouser/.bashrc \
    && echo "alias ls='ls --color=auto'" >> /home/magentouser/.bashrc \
    && echo "alias cls='clear'" >> /home/magentouser/.bashrc \
    && echo "alias mag='php bin/magento'" >> /home/magentouser/.bashrc \
    && echo "export CLICOLOR=1" >> /home/magentouser/.bashrc \
    && echo "PS1='\\[\\033[01;32m\\]\\u@\\h:\\w \\$\\[\\033[00m\\] '" >> /home/magentouser/.bashrc

# 3. Permissão na pasta interna
RUN chown -R magentouser:magentogroup /var/www/html

# 4. Ativa o usuário
USER magentouser

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Definir o bash como shell padrão
SHELL ["/bin/bash", "-c"]
