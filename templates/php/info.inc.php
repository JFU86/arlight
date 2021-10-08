<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

include_once("../system/version.inc.php");
$template = new Template();

// SQLite Version ermitteln
if (class_exists('SQLite3',false) && $config["databaseType"] == "Sqlite") {
	$data = SQLite3::version();
	$db_version = "SQLite ". $data["versionString"];
}
elseif (class_exists('Mysqli',false) && $config["databaseType"] == "Mysql") {
	$mysql = new Mysql();
	$db_version = "MySQL " . $mysql->getVersion();
}
else {
	$db_version = "n/a";
}

$vars = array(
			"{phpversion}" => phpversion(),
			"{safe_mode}" => ((int) ini_get("safe_mode") == 1) ? "On" : "Off",
			"{magic_quotes_gpc}" => (!function_exists('get_magic_quotes_gpc') || (int) get_magic_quotes_gpc() == 1) ? "On" : "Off",
			"{isWritable}" => (is_writable($config["system_path"]."/sqlite") ? "Yes" : "No"),
			"{version}" => VERSION . "." . BUILD,
			"{database}" => $db_version,
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>