<?php

ini_set('display_errors', 0);
error_reporting(0);


// DataBase connection settings
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'test1');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// Prizes congiguration
define('MONEY_TO_POINTS_FACTOR', 5);
define('POINTS_START', 10);
define('POINTS_END', 120);