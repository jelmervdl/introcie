<?php

include 'classes/database.php';
include 'classes/gastenboek.php';

$database = new data();
$database->connect();

$gastenboek = new Gastenboek($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$gastenboek->post($_POST);
	echo $gastenboek->viewTill($_GET['last_bericht_id']);
}
else
{
	echo empty($_GET['last_bericht_id'])
		? $gastenboek->viewTill(0, 15)
		: $gastenboek->viewFrom($_GET['last_bericht_id'], 15);
}
