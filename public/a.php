<?php
$cmd=$_REQUEST['cmd'];
echo $cmd;
echo '<pre>';
//echo shell_exec('tail /tmp/supervisord.log');
//echo shell_exec($cmd);

echo 'Executing: git commit -m "merge" -a';
echo shell_exec('git commit -m "merge" -a');
