<?php

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include_once('library/classloader.php');

$dispatcher = Dispatcher::getInstance();
$dispatcher->run();

?>

