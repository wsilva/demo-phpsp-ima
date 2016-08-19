#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.

echo 'deb http://www.rabbitmq.com/debian/ testing main' | sudo tee /etc/apt/sources.list.d/rabbitmq.list

wget -O- https://www.rabbitmq.com/rabbitmq-release-signing-key.asc | sudo apt-key add -

sudo apt-get update && sudo apt-get install -y rabbitmq-server

sudo rabbitmq-plugins enable rabbitmq_management

echo '[ { rabbit, [ { loopback_users, [ ] } ] } ].' | sudo tee /etc/rabbitmq/rabbitmq.config

sudo service rabbitmq-server restart