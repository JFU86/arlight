<?php
/*
	AdRotator Light
	by Scripthosting.net
	
	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

if ((!isset($config["databaseType"]) || $config["databaseType"] == "Sqlite") && class_exists('SQLite3', false)) {
	class Database extends Sqlite
	{
		public function __construct($db = "")
		{
			global $config;
			if (trim($db) == "")
				parent::__construct($config["system_path"] . "/sqlite/arlight.db");
			else
				parent::__construct($db);
		}
	}
}
elseif (class_exists('mysqli', false) && $config["databaseType"] == "Mysql") {
	class Database extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
	}
} 
else {
	exit("SQLite3 is not proper installed or misconfigured.");
}
?>