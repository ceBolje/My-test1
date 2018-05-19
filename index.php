<?php

if (version_compare(phpversion(), '7.0', '<') == true) {
    die ('PHP7 require');
}

require_once('route.php');

Route::start();

//echo 'index';