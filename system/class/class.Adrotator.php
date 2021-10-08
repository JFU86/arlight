<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

class Adrotator extends Database 
{
	/**
	 * Alias für fetchBanner()
	 * @deprecated Wird in einer zukünftigen Version entfernt
	 * @param string $order asc/desc
	 * 		Die Sortierung [aufsteigend/absteigend]
	 * @param int $format_id
	 * 		Die ID des des Formats bzw. der Kategorie
	 * @return array
	 */
	public function getData($order = "asc", $format_id = 1)
	{
		return $this->fetchBanner($order, $format_id);
	}
	
	
	/**
	 * Gibt alle Banner-Formate aus
	 * @return array
	 */
	public function getFormats()
	{		
		$result = $this->result("SELECT * FROM formats ORDER BY format_id");
		
		$data = array();
		$i = 0;
		
		while ($row = $this->fetchAssoc($result)) {
			$data[$i]["id"] = trim($row["format_id"]);
			$data[$i]["format_id"] = trim($row["format_id"]);
			$data[$i]["width"] = trim($row["width"]);
			$data[$i]["height"] = trim($row["height"]);
			$data[$i]["name"] = trim($row["name"]);
			$data[$i]["desc"] = trim($row["desc"]);
			$i++;			
		}
		return $data;
	}
	
	
	/**
	 * Gibt die ID eines Formats anhand des Namen zurück
	 * @param string $name
	 * 		Name des Formats
	 * @return int
	 */
	public function getFormatIdByName($name)
	{		
		$result = $this->result("SELECT format_id FROM formats WHERE name = '{$name}'");
		$row = $this->fetchAssoc($result);
		return $row["format_id"];
	}
	
	
	/**
	 * Fügt ein neues Format hinzu
	 * @param int $width
	 * 		Breite in Pixel für das Format
	 * @param int $height
	 * 		Höhe in Pixel für das Format
	 * @param string $desc
	 * 		Name bzw. Beschreibung des Formats
	 * @return int
	 */
	public function addFormat($width, $height, $desc)
	{
		global $config;
		
		// Filter
		$width = (int) $this->clean($width);
		$height = (int) $this->clean($height);
		$desc = $this->clean($desc, false, true);
		$desc_name = ($config["databaseType"] == "Mysql") ? "`desc`" : "desc"; // Small workaround for Mysql "describe" keyword
		
		// Prüfen, ob das Format noch nicht existiert!
		$result = $this->result("SELECT format_id FROM formats WHERE {$desc_name} = '{$desc}'");
		
		if ($this->numRows($result) == 0) {		
			// Neues Format einfügen
			$query = $this->query("INSERT INTO formats (width, height, name, alt_name, {$desc_name}) VALUES ({$width}, {$height}, '{$desc}', '', '{$desc}') ");
			return $this->insertID($query);
		}		
		return 0;
	}
	
	
	/**
	 * Editiert ein bestehendes Format
	 * @param int $format_id
	 * @param int $width
	 * @param int $height
	 * @param string $desc
	 * @return int
	 */
	public function editFormat($format_id, $width, $height, $desc)
	{		
		global $config;
		
		// Filter
		$format_id = (int) $this->clean($width);
		$width = (int) $this->clean($width);
		$height = (int) $this->clean($height);
		$desc = $this->clean($desc,false,true);
		$desc_name = ($config["databaseType"] == "Mysql") ? "`desc`" : "desc"; // Small workaround for Mysql "describe" keyword
		
		$query = $this->query(
			"UPDATE formats SET width={$width}, height={$height}, name={$desc}, desc={$desc} WHERE format_id = {$format_id}"
		);

		return $this->affectedRows($query);		
	}
	
	
	/**
	 * Löscht ein Format komplett
	 * @param int $format_id
	 * 		ID des zu löschenden Formats
	 * @return void
	 */
	public function deleteFormat($format_id)
	{		
		$format_id = (int) $this->clean($format_id);
		
		// Alle Banner mit dem Format löschen!
		$query = $this->query("DELETE FROM banner WHERE format_id = {$format_id}");
		// Format löschen!
		$query = $this->query("DELETE FROM formats WHERE format_id = {$format_id}");
		
		$logfile = new Logfile();
		// Schreibe die Aktion ins Logfile "formats"
		$logfile->addLog("formats","[DELETE] Format mit der ID {$format_id} von Admin '{$_SESSION["admin_id"]}' gelöscht");
		// Schreibe die Aktion ins Logfile "banner"
		$logfile->addLog("banner","[DELETE] Alle Banner mit der format_id {$format_id} von Admin '{$_SESSION["admin_id"]}' gelöscht");
	}
	
	
	/**
	 * Gibt einen Banner aus
	 * @param int $banner_id
	 * 		ID des zu lesenden Banners
	 * @return array
	 */
	public function getBanner($banner_id)
	{		
		$banner_id = (int) $this->clean($banner_id);
		
		$result = $this->result(
			"SELECT b.banner_id banner_id, b.name name, b.format_id format_id, b.time time, b.url url, " .
			"b.img img, b.alt alt, b.code code, b.adviews adviews, b.adclicks adclicks, b.status status ". 
			"FROM banner b LEFT JOIN formats f ON (b.format_id=f.format_id) WHERE b.banner_id = {$banner_id}"
		);
		
		$row = $this->fetchAssoc($result);

		$data = array();
		$data["id"] = $row["banner_id"];
		$data["format_id"] = $row["format_id"];
		$data["name"] = $row["name"];
		$data["time"] = $row["time"];
		$data["url"] = $row["url"];
		$data["img"] = $row["img"];
		$data["alt"] = $row["alt"];
		$data["code"] = $row["code"];
		$data["adviews"] = $row["adviews"];
		$data["adclicks"] = $row["adclicks"];
		$data["ratio"] = ($row["adviews"] > 0 && $row["adclicks"] > 0) ? round(($row["adclicks"]/$row["adviews"]) * 100, 1) : 0;
		$data["status"] = $row["status"];
		
		return $data;
	}
	
	
	/**
	 * Gibt einen zufälligen Banner aus
	 * @param $format_id 
	 * 		ID des Formats, aus dem ein Zufallsbanner gelesen werden soll
	 * @param boolean $once
	 *		 true = kein Banner wird mehrmals nacheinander gezeigt, default false
	 * @return array oder 0
	 */
	public function getRandomBanner($format_id = 1, $once = false)
	{		
		$format_id = (int) $this->clean($format_id);
		
		if ($once) {
			$last_id = isset($_SESSION["last_id"]) ? (int) $_SESSION["last_id"] : 0;
			$result = $this->result(
				"SELECT b.banner_id banner_id, {$this->getRandomFunctionName()}() as ran FROM banner b 
				LEFT JOIN formats f ON (b.format_id = f.format_id) 
				WHERE f.format_id = {$format_id} AND b.banner_id != {$last_id} AND b.status = 1 ORDER BY ran LIMIT 1"
			);
		} else {
			$result = $this->result(
				"SELECT b.banner_id banner_id, {$this->getRandomFunctionName()}() as ran 
				FROM banner b LEFT JOIN formats f ON (b.format_id=f.format_id) 
				WHERE f.format_id = {$format_id} AND b.status = 1 ORDER BY ran"
			);
		}

		if ($this->numRows($result) > 0) {
			$row = $this->fetchAssoc($result);
			$this->adview($row["banner_id"]);
			if ($once) $_SESSION["last_id"] = $row["banner_id"];
			return $this->getBanner($row["banner_id"]);
		} else {
			return 0;
		}
	}
	
	
	/**
	 * Gibt einen zufälligen Banner aus und schreibt ihn in eine HTML Seite
	 * @param int $format_id
	 * 		ID des Formats, aus dem ein Zufallsbanner gelesen werden soll
	 * @param boolean $once
	 *		true = kein Banner wird mehrmals nacheinander gezeigt, default false
	 * @return array
	 */
	public function printRandomBanner($format_id = 1, $once = false)
	{		
		global $config;
		
		$format_id = (int) $this->clean($format_id);
		
		$row = $this->getRandomBanner($format_id, $once);
		$path = "";
		$code = "";
		
		$arr = explode("/", $config["scriptpath"]);
		for ($i = 0; $i<count($arr) - 1; $i++) {
			$path .= $arr[$i] ."/";
		}
		
		if ($row["code"] != "") {
			if ($_REQUEST["get"] == "php") {
				$code .= "<!-- Begin arlight code -->" . "\r\n";
				$code .= "<script src=\"{$path}templates/js/mootools-core.js\"></script>" . "\r\n";
				$code .= "<script src=\"{$path}templates/js/arlight.yui.js\"></script>" . "\r\n";
				$code .= "<div onclick=\"mooRequest('{$path}go.php?id={$row["id"]}','dummy');\">{$row["code"]}</div>" . "\r\n";
				$code .= "<!-- End arlight code -->" . "\r\n";
			}
			else {
				$code = "<div onclick=\"document.location.href='go.php?id={$row["id"]}'\">{$row["code"]}</div>";
			}
		} else {
			if ($_REQUEST["get"] == "php"){
				$code = "<div><a href=\"{$path}go.php?id={$row["id"]}\" target=\"_blank\"><img src=\"{$row["img"]}\" alt=\"{$row["alt"]}\" border=\"0\" /></a></div>";	
			} else {
				$code = "<div><a href=\"go.php?id={$row["id"]}\" target=\"_blank\"><img src=\"{$row["img"]}\" alt=\"{$row["alt"]}\" border=\"0\" /></a></div>";
			}
		}
		
		return $code;		
	}
	
	
	/**
	 * Gibt einen zufälliges Bannerbild aus und schreibt es in eine HTML Seite
	 * @param int $format_id
	 * 		ID des Formats, aus dem ein Zufallsbanner gelesen werden soll
	 * @param boolean $once
	 *		true = kein Banner wird mehrmals nacheinander gezeigt, default false
	 * @return array
	 */
	public function printRandomImage($format_id = 1, $request_id = 0, $once = false)
	{		
		$format_id = (int) $this->clean($format_id);
		$request_id = "R" . substr($this->clean($request_id), 0, 15);
		
		$i = 0;
		do {
			$row = $this->getRandomBanner($format_id,$once);
			$_SESSION[$request_id]["id"] = $row["id"]; // Arlight >= 1.5.0
			$_SESSION["id"] = $row["id"]; // Arlight < 1.5.0
			$i++;
		} while ($row["code"] != "" && $i < 50);

		if ($row["img"] != "")
			return readfile($row["img"]);
		return array();
	}
	
	
	/**
	 * Weiterleiten zur Banner-URL
	 * @param int $banner_id
	 * 		ID des Banners zu dessen url weitergeleitet werden soll
	 * @return void
	 */
	public function goToUrl($banner_id)
	{		
		$row = $this->getBanner($banner_id);
		$format_id = $row["format_id"];
		
		$this->adclick($banner_id);
		
		if ($row["code"] == "" && $row["url"] != "") {
			$xml = new XML();
			header("Location: {$xml->translateEntities($row["url"], "xml", "plain")}");
			exit;
		} else {
			header("Location: view.php?cid={$format_id}");
			exit;
		}
	}
	
	
	/**
	 * Gibt alle Banner Datensätze aus
	 * @param string $order asc/desc
	 * 		Die Sortierung [asc/desc]
	 * @param int $format_id
	 * 		Die ID des des Formats bzw. der Kategorie
	 * @return array
	 */
	public function fetchBanner($order = "asc", $format_id = 1)
	{		
		$format_id = (int) $this->clean($format_id);
		$result = $this->result(
			"SELECT b.banner_id banner_id, b.name name, b.time time, b.url url, b.img img,
			b.alt alt, b.code code, b.adviews adviews, b.adclicks adclicks, b.status status
			FROM banner b LEFT JOIN formats f ON (b.format_id = f.format_id) 
			WHERE f.format_id = {$format_id} ORDER BY banner_id {$order}"
		);
		
		$data = array();
		$i = 0;
		
		while ($row = $this->fetchAssoc($result)) {
			$data[$i]["id"] = $row["banner_id"];
			$data[$i]["banner_id"] = $row["banner_id"];
			$data[$i]["name"] = $row["name"];
			$data[$i]["time"] = $row["time"];
			$data[$i]["url"] = $row["url"];
			$data[$i]["img"] = $row["img"];
			$data[$i]["alt"] = $row["alt"];
			$data[$i]["code"] = $row["code"];
			$data[$i]["adviews"] = $row["adviews"];
			$data[$i]["adclicks"] = $row["adclicks"];
			$data[$i]["ratio"] = ($row["adviews"] > 0 && $row["adclicks"] > 0) ? round(($row["adclicks"] / $row["adviews"]) * 100, 1) : 0;
			$data[$i]["status"] = $row["status"];
			$i++;
		}
		
		return $data;		
	}
	
	
	/**
	 * Fügt einen Banner hinzu und gibt die neue BannerID zurück
	 * @param string $name
	 * @param string $url
	 * @param string $img
	 * @param string $alt
	 * @param string $code
	 * @param string $format_id
	 * @return int
	 */
	public function addBanner($name, $url, $img, $alt, $code = "", $format_id = 1)
	{
		// Filter
		$name = $this->clean($name,false,true);
		$alt = $this->clean($alt,false,true);
		$code = $this->clean($code);
		$format_id = (int) $this->clean($format_id);
		$url = (substr($url,0,7) != "http://" && substr(trim($url),0,8) != "https://") ? "http://". $this->clean($url,false,true) : $this->clean($url,false,true);
		$img = (substr($img,0,7) != "http://" && substr(trim($img),0,8) != "https://") ? "http://". $this->clean($img,false,true) : $this->clean($img,false,true);
	
		// Insert
		if ($code == "") {
			$query = $this->query(
				"INSERT INTO banner (format_id,name,url,img,alt,time) VALUES ({$format_id},'{$name}','{$url}','{$img}','{$alt}','{$this->getSQLDateTime()}')"
			);
		} else {
			$query = $this->query(
				"INSERT INTO banner (format_id,name,code,time) VALUES ($format_id,'{$name}','{$code}','{$this->getSQLDateTime()}')"
			);
		}
		// Schreibe die Aktion ins Logfile "banner"
		$logfile = new Logfile();
		$logfile->addLog("banner","[ADD] Banner mit der ID {$this->insertID($query)} von Admin '{$_SESSION["admin_id"]}' eingetragen");
	
		return $this->insertID($query);
	}
	
	
	/**
	 * Editiert einen Banner
	 * @param int $banner_id
	 * @param string $name
	 * @param string $url
	 * @param string $img
	 * @param string $alt
	 * @param string $code
	 * @param int $format_id
	 * @return void
	 */
	public function editBanner($banner_id, $name, $url, $img, $alt, $code = "", $format_id = 0)
	{
		// Filter
		$banner_id = (int) $this->clean($banner_id);
		$name = $this->clean($name, false, true);
		$alt = $this->clean($alt, false, true);
		$code = $this->clean($code);
		$url = (substr($url,0,7) != "http://" && substr($url,0,8) != "https://") ? "http://". $this->clean($url,false,true) : $this->clean($url,false,true);
		$img = (substr($img,0,7) != "http://" && substr($img,0,8) != "https://") ? "http://". $this->clean($img,false,true) : $this->clean($img,false,true);
		$format_id = (int) $this->clean($format_id);
	
		// Update Banner
		$query = $this->query("UPDATE banner SET name='{$name}', url='{$url}', img='{$img}', alt='{$alt}',code='{$code}' WHERE banner_id = {$banner_id}");
		
		// Update Format
		if ($format_id != 0) 
			$query = $this->query("UPDATE banner SET format_id = {$format_id} WHERE banner_id = {$banner_id}");
		
		// Schreibe die Aktion ins Logfile "banner"
		$logfile = new Logfile();
		$logfile->addLog("banner", "[EDIT] Banner mit der ID {$banner_id} von Admin '{$_SESSION["admin_id"]}' editiert");
	}
	

	/**
	 * Entfernt einen Banner aus der Datenbank
	 * @param int $banner_id
	 * 		Die ID des zu löschenden Banners
	 * @return void
	 */
	public function dropBanner($banner_id)
	{
		$banner_id = (int) $this->clean($banner_id);
		$query = $this->query("DELETE FROM banner WHERE banner_id = {$banner_id}");
	
		// Schreibe die Aktion ins Logfile "banner"
		$logfile = new Logfile();
		$logfile->addLog("banner", "[DELETE] Banner mit der ID {$banner_id} von Admin '{$_SESSION["admin_id"]}' gelöscht");
	}
	
	
	/**
	 * Gibt die Anzahl aller Banner aus
	 * @return int
	 */
	public function getBannerCount()
	{
		$resultRow = $this->resultRow("SELECT count(*) anzahl FROM banner WHERE format_id = '{$this->getCurrentFormat()}'");

		return (int) $resultRow["anzahl"];
	}
	
	
	/**
	 * Ändert den Status eines Banners
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @return void
	 */
	public function setBannerStatus($banner_id)
	{
		$banner_id = (int) $this->clean($banner_id);
		$resultRow = $this->resultRow("SELECT status FROM banner WHERE banner_id = {$banner_id}");
		$ns = ($resultRow["status"] == 1) ? 0 : 1;
		$query = $this->query("UPDATE banner SET status = {$ns} WHERE banner_id = {$banner_id}");
	}
	
	
	/**
	 * Erhöht die Adviews eines Banners um 1
	 * @deprecated Zukünftig adview(1) verwenden. Diese Funktion wird bald entfernt.
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @return void
	 */
	private function setAdviews($banner_id)
	{
		$this->adview($banner_id);
	}
	
	
	/**
	 * Erhöht die Adclicks eines Banners um 1
	 * @deprecated Zukünftig adclick(1) verwenden. Diese Funktion wird bald entfernt.
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @return void
	 */
	private function setAdclicks($banner_id)
	{
		$this->adclick($banner_id);
	}
	
	
	/**
	 * Erhöht die Adviews eines Banners um 1
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @return void
	 */
	private function adview($banner_id)
	{
		if ($this->ipCheck($banner_id, "view")) {
			$banner_id = (int) $this->clean($banner_id);
			$query = $this->query("UPDATE banner SET adviews = adviews+1 WHERE banner_id = {$banner_id}");
		}
	}


	/**
	 * Erhöht die Adclicks eines Banners um 1
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @return void
	 */
	private function adclick($banner_id)
	{
		// Der Banner muss bereits angezeigt worden sein, bevor ein Klick gezählt werden darf!
		if (!$this->ipCheck($banner_id, "view", true) && $this->ipCheck($banner_id, "click")) {
			$banner_id = (int) $this->clean($banner_id);
			$query = $this->query("UPDATE banner SET adclicks = adclicks+1 WHERE banner_id = {$banner_id}");
		}
	}


	/**
	 * Gibt false zurück, wenn die IP noch für die Statistik gesperrt ist
	 * @param int $banner_id
	 * 		Die ID des Banners
	 * @param string $mode
	 * 		Mögliche Werte sind "view" oder "click"
	 * @param boolean $checkOnly
	 * 		Nur prüfen und nichts eintragen (default: false)
	 * @return boolean
	 */
	private function ipCheck($banner_id, $mode = "view", $checkOnly = false)
	{
		$banner_id = (int) $this->clean($banner_id);
		
		if ($banner_id != "") {
			$jetzt = time();
			$morgen = strtotime(date("Y-m-d 00:00:00", strtotime("tomorrow")));
			$client = ($_REQUEST["get"] == "php" && $_REQUEST["ip"] != NULL ) ? $_REQUEST["ip"] : $_SERVER["REMOTE_ADDR"];
			
			// Prüfen, ob der Aufruf bereits in der Reloadsperre blockiert wird
			$resultRow = $this->resultRow(
				"SELECT count(*) as count FROM reload WHERE ipadress = '{$client}' AND type = '{$mode}' AND banner_id = '{$banner_id}' AND time > '{$jetzt}'"
			);

			if ($resultRow["count"] > 0) {
				// Reloadsperre ist noch aktiv! Nichts unternehmen.
				return false;
			} else {
				// Keine Reloadsperre aktiv! Sperre eintragen.
				$query = $this->query("DELETE FROM reload WHERE time < '{$jetzt}'");
				if (!$checkOnly)
					$query = $this->query("INSERT INTO reload (time, ipadress, type, banner_id) VALUES ('{$morgen}', '{$client}', '{$mode}', {$banner_id})");
				return true;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Gibt das aktuell angewählte Format aus
	 * @return int
	 */
	public function getCurrentFormat()
	{
		if (!isset($_SESSION["format_id"]))
			return 1;
		
		return (int) $_SESSION["format_id"];
	}
	
	
	/**
	 * Legt das aktuelle Format fest
	 * @param int $format_id
	 *		Die ID des Formats
	 * @return void
	 */
	public function setCurrentFormat($format_id)
	{
		$format_id = (int) $this->clean($format_id);
		
		$resultRow = $this->resultRow("SELECT * FROM formats WHERE format_id = {$format_id}");
		if (!empty($resultRow)) {
			$_SESSION["format_id"] = $format_id;
			$_SESSION["width"] = $resultRow["width"];
			$_SESSION["height"] = $resultRow["height"];
		}
	}
	
	
	/**
	 * Gibt die Breite des aktuellen Formats aus
	 * @return int
	 */
	public function getWidth()
	{
		if (isset($_SESSION["width"])) {
			return (int) $_SESSION["width"];
		} else {
			return 468;
		}
	}
	
	
	/**
	 * Gibt die Höhe des aktuellen Formats aus
	 * @return int
	 */
	public function getHeight()
	{
		if (isset($_SESSION["height"])) {
			return (int) $_SESSION["height"];
		} else {
			return 60;
		}		
	}
}
?>