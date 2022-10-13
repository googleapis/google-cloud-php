FROM gcr.io/gcp-runtimes/ubuntu_16_0_4
ENV PHP_DIR=/opt/php80
ENV PHP_SRC_DIR=/usr/local/src/php80-build
ENV PATH=${PATH}:/usr/local/bin:${PHP_DIR}/bin

RUN apt-get update && \
    apt-get -y install \
            autoconf \
            build-essential \
            git-core \
            jq \
            libbz2-dev \
            libcurl4-openssl-dev \
            libc-client2007e \
            libc-client2007e-dev \
            libfcgi-dev \
            libfcgi0ldbl \
            libfreetype6-dev \
            libicu-dev \
            libkrb5-dev \
            libmcrypt-dev \
            libpq-dev \
            libssl-dev \
            libxml2-dev \
            libzip-dev \
            unixodbc-dev \
            wget \
            zip \
            zlib1g-dev \
            pkg-config \
            libonig-dev \
            libffi-dev

# Remove old version of PHP
RUN apt purge -y php7.0-common

# Install PHP 8.0
RUN ln -s /usr/lib/libc-client.a /usr/lib/x86_64-linux-gnu/libc-client.a && \
    mkdir -p ${PHP_DIR} ${PHP_SRC_DIR} ${PHP_DIR}/lib/conf.d && \
    cd ${PHP_SRC_DIR} && \
    wget http://us1.php.net/get/php-8.0.1.tar.bz2/from/this/mirror \
         -O php-8.0.1.tar.bz2 && \
    tar jxf php-8.0.1.tar.bz2 && \
    cd php-8.0.1 && \
    ./configure \
        --prefix=${PHP_DIR} \
        --with-config-file-scan-dir=${PHP_DIR}/lib/conf.d \
        --with-zlib-dir \
        --enable-mbstring \
        --enable-soap \
        --enable-intl \
        --enable-calendar \
        --with-curl \
        --with-zlib \
        --disable-rpath \
        --with-bz2 \
        --with-zlib \
        --enable-sockets \
        --enable-sysvsem \
        --enable-sysvshm \
        --enable-sysvmsg \
        --enable-pcntl \
        --enable-mbregex \
        --enable-exif \
        --enable-bcmath \
        --with-mhash \
        --with-openssl \
        --with-libdir=/lib/x86_64-linux-gnu \
        --enable-ftp \
        --with-imap \
        --with-imap-ssl \
        --with-gettext \
        --with-zip \
        --with-kerberos \
        --without-sqlite3 \
        --without-pdo-sqlite \
        --with-pear && \
        make && \
        make install && \
        cp php.ini-production ${PHP_DIR}/lib/php.ini

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === rtrim(file_get_contents('https://composer.github.io/installer.sig'))) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --filename=composer --install-dir=/usr/local/bin

# Install phpdoc
RUN wget -O /usr/local/bin/phpdoc "https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.3.1/phpDocumentor.phar" \
  && chmod +x /usr/local/bin/phpdoc

# Install Python3
RUN wget https://www.python.org/ftp/python/3.9.14/Python-3.9.14.tgz \
    && tar -xvf Python-3.9.14.tgz \
    && ./Python-3.9.14/configure --enable-optimizations \
    && make altinstall

# Install pip
RUN wget -O /tmp/get-pip.py 'https://bootstrap.pypa.io/get-pip.py' \
  && python3.9 /tmp/get-pip.py \
  && rm /tmp/get-pip.py \
  && python3.9 -m pip

# Install docsuploader
COPY requirements.txt .
RUN python3.9 -m pip install --require-hashes -r requirements.txt

