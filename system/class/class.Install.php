<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

class Install
{	
	/**
	 * Schreibt die Configdatei
	 */
	public function writeConfig()
	{		
		global $config;
		
		$vars = array(
			"{language}"		=>	$_REQUEST["language"],
			"{databaseType}"	=>	$_REQUEST["database"],
			// Specific for sql servers
			"{dbhost}"			=>	(isset($_REQUEST["dbhost"])) ? $_REQUEST["dbhost"] : "localhost",
			"{dbuser}"			=>	(isset($_REQUEST["dbuser"])) ? $_REQUEST["dbuser"] : "root",
			"{dbpass}"			=>	(isset($_REQUEST["dbpass"])) ? $_REQUEST["dbpass"] : "",
			"{dbname}"			=>	(isset($_REQUEST["dbname"])) ? $_REQUEST["dbname"] : "arlight",
			"{dbport}"			=>	(isset($_REQUEST["dbport"])) ? (int) $_REQUEST["dbport"] : 3306,
			"{dbsocket}"		=>	(isset($_REQUEST["dbsocket"])) ? $_REQUEST["dbsocket"] : "",
		);

		$tpl = new Template();		
		$newData = $tpl->output($config["system_path"] . "/temp/config.txt", $vars);
		$writeConfigFile = file_put_contents($config["system_path"] . "/config/config.inc.php", $newData);
		@unlink($config["system_path"]."/temp/config.txt");
		@unlink($config["system_path"]."/config/config.min.inc.php");
	}
	
	
	/**
	 * Installiert arlight auf der Datenbank
	 * @return void
	 */
	public function databaseInstall()
	{		
		global $config;
		
		// Alle alten Dateien löschen (Version >= 0.7.0)
		@unlink(realpath($config["system_path"]."/sqlite/arlight.db"));
		@unlink(realpath($config["system_path"]."/sqlite/language.db"));
		@unlink(realpath($config["system_path"]."/log/formats.log"));
		@unlink(realpath($config["system_path"]."/log/banner.log"));
		@unlink(realpath($config["system_path"]."/log/user.log"));

		// Logdateien anlegen
		$put = file_put_contents($config["system_path"]."/log/user.log", "");
		$put = file_put_contents($config["system_path"]."/log/banner.log", "");
		$put = file_put_contents($config["system_path"]."/log/formats.log", "");
		$chmod = chmod($config["system_path"]."/log/user.log", 0777);
		$chmod = chmod($config["system_path"]."/log/banner.log", 0777);
		$chmod = chmod($config["system_path"]."/log/formats.log", 0777);
	
		// Create selected database
		if ($_REQUEST["database"] == "Sqlite") {
			// Create SQLite database file
			if (!file_exists($config["system_path"]."/sqlite/arlight.db")) {
				$put = file_put_contents($config["system_path"]."/sqlite/arlight.db", "");
				$chmod = chmod($config["system_path"]."/sqlite/arlight.db", 0777);
			}
			$sql = file_get_contents($config["system_path"]."/temp/sqlite.sql");
		}
		elseif ($_REQUEST["database"] == "Mysql") {
			$sql = file_get_contents($config["system_path"]."/temp/mysql.sql");
		}
		else {
			exit("Unknown or incompatible database selected! Please go back and select a valid database!");
		}
		
		$dbCon = new Database();
		$part = explode("/* SPLIT */",trim($sql));
		foreach ($part as $value) {
			if ($value != "") {
				$query = $dbCon->query(trim($value));
			}
		}
		
		// Add user "admin"
		$admin = new Admin();
		$admin->register($_REQUEST["username"], $_REQUEST["pass0"]);
		
		$this->createLanguageDB();
		// Remove update files
		@unlink($config["system_path"]."/temp/sqlite.sql");
		@unlink($config["system_path"]."/temp/sqlite-update.sql");
		@unlink($config["system_path"]."/temp/mysql.sql");
		@unlink($config["system_path"]."/temp/mysql-update.sql");
		@unlink($config["system_path"] . "/temp/UPDATE");
	}	
	
	
	/**
	 * Aktualisiert die Datenbank
	 * @return boolean
	 */
	public function databaseUpdate()
	{		
		global $config;
		
		// Gewählte Datenbank auswählen und aktualisieren
		if (!isset($config["databaseType"]) || $config["databaseType"] == "Sqlite") {
			$updateFile = $config["system_path"]."/temp/sqlite-update.sql";
			if (file_exists($updateFile))
				$sql = file_get_contents($updateFile);
			else
				return false;
		}
		elseif ($config["databaseType"] == "Mysql"){
			$updateFile = $config["system_path"]."/temp/mysql-update.sql";
			if (file_exists($updateFile))
				$sql = file_get_contents($updateFile);
			else
				return false;
		}
		else {
			exit("Unknown or incompatible database selected! Please go back and select a valid database!");
		}
		
		$dbCon = new Database();
		$part = explode("/* SPLIT */", trim($sql));
		foreach ($part as $value) {
			if ($value != "") {
				$query = $dbCon->query(trim($value));
			}
		}
		
		// Temporäre Dateien löschen
		@unlink($config["system_path"]."/temp/sqlite.sql");
		@unlink($config["system_path"]."/temp/mysql.sql");
		@unlink($config["system_path"]."/temp/sqlite-update.sql");
		@unlink($config["system_path"]."/temp/mysql-update.sql");
		@unlink($config["system_path"]."/temp/config.txt");
		@unlink($config["system_path"]."/temp/UPDATE");
		@unlink($config["system_path"]."/config/config.min.inc.php");
		@unlink($config["basepath"]."/admin/install.php");
		@unlink($config["basepath"]."/admin/.install");
		
		// Language.db neu erstellen
		if (file_exists($config["system_path"]."/temp/language.sql")) $this->createLanguageDB();
		
		return true;
	}
	
	
	/**
	 * Erstelle eine neue Sprachdatenbank
	 */
	public function createLanguageDB()
	{	
		global $config;
	
		@unlink($config["system_path"]."/sqlite/language.db");
	
		if (!file_exists($config["system_path"]."/sqlite/language.db")) {
			$put = file_put_contents($config["system_path"]."/sqlite/language.db", "");
			$chmod = chmod($config["system_path"]."/sqlite/language.db", 0777);		
	
			$sqlite = new Sqlite($config["system_path"] . "/sqlite/language.db");
			$sql = file_get_contents($config["system_path"]."/temp/language.sql");
			$part = explode("/* SPLIT */", trim($sql));
		
			foreach ($part as $value) {
				if ($value != "") {
					$query = $sqlite->query(trim($value));
				}
			}
			@unlink($config["system_path"]."/temp/language.sql");
		}
	}
}
?>