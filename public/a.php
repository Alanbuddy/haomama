#!/usr/bin/php

<?php
$cmd=$_REQUEST['cmd'];
echo $cmd;
//echo '<pre>';
//echo shell_exec('tail /tmp/supervisord.log');
//echo shell_exec($cmd);

echo 'Executing: git commit -m "merge" -a'."\n";
echo shell_exec('git commit -m "merge" -a');
echo 'Executing: git pull'."\n";
echo shell_exec('git pull');
echo 'Executing: git push'."\n";
echo shell_exec('git push');
