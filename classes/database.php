<?php
class data
{
	public function connect(){
		$db = "introcie";
		$user = "introcie";
		$host = "localhost";
		$password = "password";
		
		$connection = mysql_connect($host, $user, $password) or die(mysql_error());
		mysql_select_db($db,$connection) or die(mysql_error());
	}
}
