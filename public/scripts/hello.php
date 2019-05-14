<?php

# unused scripts

date_default_timezone_set("Asia/Manila");
echo date('Y-m-d H:i:s') . ": Start Processing Background Calculation" . PHP_EOL;

$logs = "/var/www/html/mycoop/public/my_logs.log";
error_log(date('Y-m-d H:i:s') . ": Running Background Process. - " . $argv[1] . PHP_EOL, 3, $logs);

echo date('Y-m-d H:i:s') . " : End Processing" . PHP_EOL;

?>
