#!/bin/bash

chown -R www-data:www-data /var/www/html/
chmod -R 755 /var/www/html/

$(which php) /var/www/html/start.php

apache2-foreground
