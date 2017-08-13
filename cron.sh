#!/bin/bash 
step=1 #间隔的秒数，不能大于60

for (( i = 0; i < 60; i=(i+step) )); do
    #$(php '/home/test.php')
    #$(php /var/www/baby.com/artisan schedule:run >> /dev/null 2>&1)
    $(php /var/www/baby.com/artisan schedule:run >> /tmp/cron 2>&1)
    echo 'run'
    sleep $step
done

exit 0
