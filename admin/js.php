<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

// Einbinden der Konfigurationsdatei
if (file_exists("../system/config/config.inc.php")) {
	include_once("../system/config/config.inc.php");
}
else {
	include_once("../system/config/config.min.inc.php");
}

// Die Ausgabe wird auf Javascript UTF-8 festgelegt
header('Content-type: text/javascript; charset=UTF-8');

$f = trim($_REQUEST["f"]);

$tpl = new Template();
$yui = false;

// Laden der JavaScript Datei
// Falls eine YUI Komprimierte Datei vorhanden ist, dann wähle diese
if (file_exists($config["basepath"]."/templates/js/{$f}.yui.js") && $config["debug"] == false) {
	$output = $tpl->output($config["basepath"]."/templates/js/{$f}.yui.js");
	$yui = true;
}
// Sonst versuche die Standarddatei zu laden
elseif (file_exists($config["basepath"]."/templates/js/{$f}.js")) {
	$output = $tpl->output($config["basepath"]."/templates/js/{$f}.js");
	$yui = false;
}
// Wenn die Datei nicht existiert dann gibt es eine leere Rückgabe
else {
	exit;
}

// Im Debugmodus werden keine Anpassungen der js Dateien vorgenommen
if ($config["debug"] == false && !$yui) {
	// Komprimieren der Ausgabe	
	/* delete online line comments */
	$output = preg_replace("/(\/\/.*)/", "", $output);
	/* replace line breaks */
	$output = str_replace("\r\n", "", $output);
	$output = str_replace("\n", "", $output);
	/* delete multiline comments */
	if (substr($f,0,8) != "mootools")
	$output = preg_replace("/(\/\*.*\*\/)/sU", "", $output);
	/* replace tabs */
	$output = str_replace("\t", " ", $output);
}

// Ausgeben der JavaScript-Datei
echo trim($output);

?>