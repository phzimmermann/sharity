<?php

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include_once('library/classloader.php');

$dispatcher = Dispatcher::getInstance();
$dispatcher->run();



/*
$session = Session::getInstance();
$tpl = Tpl::getInstance();



$handleString = $_REQUEST['h'];
$actionString = $_REQUEST['a'];
$identification = $_REQUEST['i'];

$dispatcher = Dispatcher::getInstance();
$dispatcher->start($handleString, $actionString, $identification);
$dispatcher->run();





/*

echo "handle: " . $handleString;
echo "action: " . $actionString;
echo "id: " . $identfication;
*/


/*$fipi = new User(0);
$fipi->setName('fipi');
$fipi->setPassword('1234');
$fipi->setRole('admin');
$fipi->save();

*/
/*
if($dispatcher->renderLayout()) {
	Tpl::show($dispatcher->getSiteValues());
	// eval("\$tpl->output(\"".$tpl->get("site")."\");");
}else{

	echo $dispatcher->getContent();
}
/*

$party = new Party();
$party->setName('Partyyy xD');
$party->setClub(new Entry(5));
$party->save();
*/
?>

