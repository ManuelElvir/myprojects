# Utilisez une image PHP avec Apache
FROM php:8.2-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copiez les fichiers de votre projet
COPY . .

# Copiez les fichiers du repertoire vendor
# reactivate later
# COPY ./vendor /var/www/html/vendor

# Installez les dépendances nécessaires
RUN apt-get update \
    && apt-get install -y \
        git \
        unzip \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        librabbitmq-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl opcache

# Installer l'extension amqp
RUN apt-get install -y libssl-dev pkg-config \
    && pecl install amqp \
    && pecl install redis \
    && docker-php-ext-enable amqp

# Installez Node.js 16
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Installe Yarn
RUN curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /usr/share/keyrings/yarnkey.gpg >/dev/null \
    && echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian stable main" | tee /etc/apt/sources.list.d/yarn.list >/dev/null \
    && apt-get update && apt-get install -y yarn

# Installez les dépendances PHP avec Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installez Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Installez les dépendances JavaScript avec Yarn
RUN yarn install

# Compilez les assets avec Yarn
RUN yarn build
# RUN yarn watch

# Create the folder var
RUN mkdir var

# Définir les autorisations pour le répertoire des caches
RUN chown -R www-data:www-data var

# Activez le module Apache mod_rewrite 
RUN a2enmod rewrite

# install browser extension
# RUN apt-get install chromium-chromedriver firefox-geckodriver

# Exposez le port 80 pour Apache
EXPOSE 80

# Lancez Apache en premier plan
CMD ["apache2-foreground"]

# Configuration personnalisée pour Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf
