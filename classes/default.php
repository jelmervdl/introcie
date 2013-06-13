<?php

Class normal{

var $titel;
var $content;
var $youtube;
var $data;

public function gegevens(){
	$query = "SELECT * FROM `pagina` WHERE `naam` = '".$this->titel."'";
	$array_res = mysql_fetch_assoc(mysql_query($query));
	return $array_res;
}

}
?>
