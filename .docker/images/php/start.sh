#!/bin/bash

echo "* * * * * $(which php) /var/www/html/cron.php > /dev/null 2>&1" | crontab -u www-data -

/etc/init.d/cron start
apache2-foreground
