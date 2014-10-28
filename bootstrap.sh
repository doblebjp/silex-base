#!/usr/bin/env bash

# variables
SERVER_TIMEZONE="Europe/Madrid"
DOCUMENT_ROOT="web"

# set timezone 
echo $SERVER_TIMEZONE | tee /etc/timezone
dpkg-reconfigure --frontend noninteractive tzdata

# update package list
apt-get update

# apache
apt-get install -y apache2

# php
apt-get install -y php5 php-apc php5-mysql php5-json php5-intl php5-xdebug
echo "date.timezone = $SERVER_TIMEZONE" > /etc/php5/mods-available/vagrant.ini
echo "xdebug.max_nesting_level = 250" >> /etc/php5/mods-available/vagrant.ini
(cd /etc/php5/cli/conf.d && ln -sf ../../mods-available/vagrant.ini 99-vagrant.ini) 
(cd /etc/php5/apache2/conf.d && ln -sf ../../mods-available/vagrant.ini 99-vagrant.ini) 

# mysql
DEBIAN_FRONTEND=noninteractive apt-get install -y mysql-server

# composer
apt-get install -y curl
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod u+x /usr/local/bin/composer

# application setup
rm -rf /var/www/html
ln -fs "/vagrant/$DOCUMENT_ROOT" /var/www/html
cd /vagrant 
composer install

# reload
service apache2 reload
