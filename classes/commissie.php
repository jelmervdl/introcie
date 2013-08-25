<?php

Class commissie {

var $data;

public function showleden(){
	$query = "SELECT * FROM `commissie` WHERE `zichtbaar` = 1 ORDER BY `commissie_id` ASC;";
	$res = mysql_query($query);
	$output = "";
	while ($row = mysql_fetch_assoc($res)) {
		$output .= "<div class=\"commissie\"><img src=\"".$row['foto']."\" alt=\"".$row['naam']."\" class=\"commissiefoto_lid\" \><span class=\"commissielid\">".$row['naam']."</span><br /><span class=\"commissiefunctie\">".$row['positie']."</span><br /><br />".nl2br($row['omschrijving'])."</div><br />";
	}

	return $output;
}

}
?>