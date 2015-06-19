FROM tutum/apache-php:latest

# Install packages
RUN apt-get update
RUN apt-get install -y \
  vim \
  php5-xdebug

# Config
COPY apache_default /etc/apache2/sites-available/000-default.conf

# Expose volumes
VOLUME ["/var/www", "/etc/apache2/sites-enabled"]

EXPOSE 80 9000