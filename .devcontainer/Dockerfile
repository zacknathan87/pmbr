FROM ubuntu:22.04

# Set non-interactive mode
ENV DEBIAN_FRONTEND=noninteractive

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    gnupg \
    lsb-release \
    software-properties-common \
    tzdata \
    sudo \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install Chromium for Puppeteer (avoid Ubuntu snap wrapper by using PPA)
RUN add-apt-repository -y ppa:saiarcot895/chromium-dev \
    && apt-get update \
    && apt-get install -y \
        chromium-browser \
        chromium-codecs-ffmpeg-extra \
        fonts-ipafont-gothic \
        fonts-wqy-zenhei \
        fonts-thai-tlwg \
        fonts-kacst \
        fonts-freefont-ttf \
        libxss1 \
        --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Bun
RUN curl -fsSL https://bun.sh/install | bash && \
    mv /root/.bun /usr/local/bun && \
    ln -s /usr/local/bun/bin/bun /usr/local/bin/bun

# Add PHP repository
RUN add-apt-repository ppa:ondrej/php -y

# Install PHP 7.4 and extensions
RUN apt-get update && apt-get install -y \
        php7.4 \
    php7.4-cli \
    php7.4-fpm \
    php7.4-mysql \
    php7.4-mbstring \
    php7.4-xml \
    php7.4-curl \
    php7.4-zip \
    php7.4-intl \
    php7.4-gd \
    php7.4-bcmath \
    php7.4-tokenizer \
    php7.4-fileinfo \
    php7.4-posix \
    php7.4-exif \
    nginx \
    openssl \
    git \
    unzip \
    supervisor \
    cron \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure PHP-FPM
RUN sed -i 's/listen = \/run\/php\/php7.4-fpm.sock/listen = 127.0.0.1:9000/' /etc/php/7.4/fpm/pool.d/www.conf
RUN mkdir -p /run/php

# Configure Nginx
COPY .devcontainer/nginx.conf /etc/nginx/sites-available/default
RUN rm -f /etc/nginx/sites-enabled/default && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/
RUN mkdir -p /var/log/nginx /var/lib/nginx/body /var/lib/nginx/proxy /var/lib/nginx/fastcgi /var/lib/nginx/uwsgi /var/lib/nginx/scgi && \
    chown -R www-data:www-data /var/log/nginx /var/lib/nginx
RUN touch /var/log/php7.4-fpm.log && chown www-data:www-data /var/log/php7.4-fpm.log

# Generate self-signed SSL certificate and DH parameters
RUN mkdir -p /etc/ssl/private && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/selfsigned.key -out /etc/ssl/certs/selfsigned.crt -subj "/C=US/ST=State/L=City/O=Organization/CN=localhost" && \
    openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048

# Configure Supervisor
COPY .devcontainer/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Create workspace user
RUN useradd -m -s /bin/bash vscode && \
    echo 'vscode ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers && \
    chown -R vscode:vscode /home/vscode

# Set Puppeteer environment variables
# - Ensure we never download the bundled Chromium (often x86_64) in ARM64 containers
# - Force Puppeteer to use the system-installed ARM64 Chromium
ENV PUPPETEER_SKIP_DOWNLOAD=true
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser
ENV PUPPETEER_ARGS=--no-sandbox,--disable-setuid-sandbox,--disable-dev-shm-usage,--disable-gpu

# Set permissions
RUN chown -R vscode:vscode /var/www
