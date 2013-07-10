<?php

require 'classes/database.php';

$db = new data();
$db->connect();

$stmt = mysql_query("SELECT COUNT(*) FROM inschrijvingen");

echo mysql_result($stmt, 0);
