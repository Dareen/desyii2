FROM tutum/apache-php:latest

ENV     GITHUB_TOKEN        your_generated_github_token

# Install packages
RUN apt-get update
RUN apt-get install -y \
  vim \
  # curl is needed to install php composer
  curl \
  # git is needed for composer to install dependencies from git
  git \
  php5-xdebug

# Config
COPY apache_default /etc/apache2/sites-available/000-default.conf

# Copy the project dir to run migrations later
ADD www/ /var/www

# Expose volumes - before composer update so the generated
# autoload.php doesn't get overriden, needed later for yii migrate
VOLUME ["/var/www", "/etc/apache2/sites-enabled"]

RUN \
    # Enable apache rewrite module
    a2enmod rewrite && \
    # php composer
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    # yii2 requires composer-asset-plugin
    composer config --global github-oauth.github.com $GITHUB_TOKEN && \
    composer global require "fxp/composer-asset-plugin:~1.0.0"

# required dependencies
WORKDIR /var/www/default
RUN composer update

EXPOSE 80 9000
