<?php
error_reporting('E_NONE');

Class gastenboek {

var $data;

public function view($pagina){
	$query = "SELECT * FROM `gastenboek` ORDER BY `bericht_id` DESC LIMIT ".($pagina-1)*15 ." , 15";
	$res = mysql_query($query);
	$output = "";
	while ($row = mysql_fetch_assoc($res)) {
		$output .= "<div class=\"gastenboek\"><div class=\"gastenboek_info\"><span class=\"gastenboek_naam\">".$row['naam']."</span><span class=\"gastenboek_datum\">".date('d-m-Y H:i', $row['datum'])."</span></div>";
		$output .= "<div class=\"gastenboek_bericht\">".nl2br($row['bericht'])."</div></div><br />";
	}
	$sql = "SELECT COUNT( * ) AS 'aantal' FROM `gastenboek`";
	$result = mysql_fetch_assoc(mysql_query($sql));
	$posts = $result['aantal'];
	$paginas = ceil($posts/15);
	if ($paginas > 1){
		$output .= "<br /><div class=\"gastenboek_pagina\">";
		for ($i = 1;$i <= $paginas; $i++){
			if ($i != $pagina){
				$output .= "<a class=\"gastenboek\" href=\"gastenboek.php?pagina=".$i."\">".$i."</a>&nbsp;";
			} else {
				$output .= $i."&nbsp;";
			}
		}
		$output .= "</div>";
	}
	//oplossing voor giga hoeveelheid pagina's fixen
	return $output;
}

public function post($post){
	$post['naam'] =htmlentities($post['naam'], ENT_QUOTES, "UTF-8");
	$post['bericht'] = htmlentities($post['bericht'], ENT_QUOTES, "UTF-8");
	if ($this->check_email_address($post['email'])){
		$query = "INSERT INTO `gastenboek` (`naam`, `email`, `bericht`, `datum`, `ip`) VALUES ('".$post['naam']."', '".$post['email']."', '".$post['bericht']."', ".time().", '".$_SERVER['REMOTE_ADDR']."');";
		if (!$res = mysql_query($query)){
			$return = False;
		} else {
			$return = True;
		}
	} else {
		$return = False;
	}
	
	return $return;
}


private function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
?([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

}
?>
	
