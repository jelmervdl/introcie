<?php

class Gastenboek
{
	private $db;

	public function Gastenboek($db)
	{
		$this->db = $db;
	}

	public function view($pagina, $aantal)
	{
		$query = sprintf("SELECT * FROM `gastenboek` ORDER BY `bericht_id` DESC LIMIT %d, %d", $pagina * $aantal, $aantal);
		return $this->render(mysql_query($query));
	}

	public function viewFrom($bericht_id, $aantal)
	{
		$query = sprintf("SELECT * FROM `gastenboek` WHERE bericht_id < %d ORDER BY `bericht_id` DESC LIMIT %d", $bericht_id, $aantal);
		return $this->render(mysql_query($query));
	}

	public function viewTill($bericht_id, $aantal)
	{
		$query = sprintf("SELECT * FROM `gastenboek` WHERE bericht_id > %d ORDER BY `bericht_id` DESC LIMIT %d", $bericht_id, $aantal);
		return $this->render(mysql_query($query));
	}

	public function post($post)
	{
		$post['naam'] = mysql_real_escape_string($post['naam']);
		$post['bericht'] = mysql_real_escape_string($post['bericht']);

		if (!$this->check_email_address($post['email']))
			return false;

		$query = sprintf("INSERT INTO `gastenboek` (`naam`, `email`, `bericht`, `datum`, `ip`) VALUES ('%s', '%s', '%s', %d, '%s')", 
			$post['naam'], $post['email'], $post['bericht'], time(), $_SERVER['REMOTE_ADDR']);

		return mysql_query($query);
	}

	private function render($res)
	{
		$output = array();
		while ($row = mysql_fetch_assoc($res))
		{
			$output[] =
				'<section class="gastenboek-entry" id="bericht-' . $row['bericht_id'] . '">
					<aside class="gastenboek-meta">
						<span class="gastenboek-naam">'.htmlspecialchars($row['naam'], ENT_COMPAT, 'UTF-8').'</span>
						<span class="gastenboek-datum">'.date('d-m-Y H:i', $row['datum']).'</span>
					</aside>
					<p class="gastenboek-bericht">'.nl2br(htmlspecialchars($row['bericht'], ENT_COMPAT, 'UTF-8')).'</p>
				</section>';
		}

		//oplossing voor giga hoeveelheid pagina's fixen
		return implode("\n", $output);
	}

	private function check_email_address($email)
	{
		return preg_match('/^[^@]+@[^@]+\.[a-z]+$/i', $email);
	}
}
