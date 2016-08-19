#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

## rabbitmq installation
echo 'deb http://www.rabbitmq.com/debian/ testing main' | sudo tee /etc/apt/sources.list.d/rabbitmq.list
wget -O- https://www.rabbitmq.com/rabbitmq-release-signing-key.asc | sudo apt-key add -
sudo apt-get update && sudo apt-get install -y rabbitmq-server
sudo rabbitmq-plugins enable rabbitmq_management
echo '[ { rabbit, [ { loopback_users, [ ] } ] } ].' | sudo tee /etc/rabbitmq/rabbitmq.config
sudo service rabbitmq-server restart

## php redis installation
git clone -b php7 https://github.com/phpredis/phpredis.git
sudo mv phpredis /etc/
cd /etc/phpredis && phpize && ./configure && make && sudo make install 
echo "extension=/etc/phpredis/modules/redis.so" | sudo tee /etc/php/7.0/fpm/conf.d/redis.ini
echo "extension=/etc/phpredis/modules/redis.so" | sudo tee /etc/php/7.0/cli/conf.d/redis.ini
sudo service php7.0-fpm restart
sudo service nginx restart