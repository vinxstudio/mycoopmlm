<?php
//echo "test";
error_reporting(E_ALL); 
ini_set('display_errors', 1);
// shell_exec('php -f crawl_income.php > /dev/null 2>/dev/null &');

// exec('whoami');
// shell_exec(sprintf("php C:\wamp64\www\Development\MyCoop\public\hello.php 931 > C:\wamp64\www\Development\MyCoop\public\hello_logs.text &"));
echo shell_exec("sh /var/www/html/mycoop/public/run.sh 931");


// echo "test";
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// // shell_exec('php -f crawl_income.php > /dev/null 2>/dev/null &');

// // exec('whoami');
// // shell_exec(sprintf("php C:\wamp64\www\Development\MyCoop\public\hello.php 931 > C:\wamp64\www\Development\MyCoop\public\hello_logs.text &"));
// echo system("usr/bin/php /var/www/html/mycoop/public/hello.php 931 > /var/www/html/mycoop/public/hello_logs.text &");


?>
