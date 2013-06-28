<?php

include 'classes/database.php';
include 'classes/gastenboek.php';

$database = new data();
$database->connect();

$gastenboek = new Gastenboek($database);

$kleuren_van_gras = array('groen', 'geel', 'bruin', 'paars', 'green', 'yellow',
	'white', 'pink', 'kaki', 'purple', 'black', 'applepie');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (!in_array(strtolower(trim($_POST['captcha'])), $kleuren_van_gras))
		die('Nope');

	$gastenboek->post($_POST);

	echo $gastenboek->viewTill($_GET['last_bericht_id'], 15);
}
else
{
	echo empty($_GET['last_bericht_id'])
		? $gastenboek->viewTill(0, 15)
		: $gastenboek->viewFrom($_GET['last_bericht_id'], 15);
}
