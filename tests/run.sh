#!/usr/bin/env bash

source ./wp.env
docker exec -i colormeshop_wp_plugin_wordpress bash -c "cd /var/www/html/wp-content/plugins/colormeshop-wp-plugin \
&& ./bin/install-wp-tests.sh unit_test root $MYSQL_ROOT_PASSWORD mysql \
&& ./vendor/bin/phpunit"
