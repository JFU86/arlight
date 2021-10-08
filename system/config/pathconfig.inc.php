<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

// Starte eine neue Session bzw. setze eine bestehende fort
session_name("arlightsid");
if(!isset($_SESSION)) session_start();

// Basispfad zum Script (intern)
$config["basepath"] = substr(__FILE__,0,-33);
// Scriptpfad zum Script relativ zur Domain
$config["scriptpath"] = "http://".$_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
$config["template_path"] = $config["basepath"]."/templates";
$config["include_path"] = $config["basepath"]."/templates/php";
$config["system_path"] = $config["basepath"]."/system";
$config["class_path"] = $config["basepath"]."/system/class";

// Language global zur Verfügung stellen
$config["language"] = (!isset($_SESSION["language"])) ? $config["defaultLanguage"] : $_SESSION["language"];

////////////////////////////////////////////////////////////////////////
// Teile PHP das Standardverzeichnis für alle Klassen und Interfaces mit
////////////////////////////////////////////////////////////////////////
spl_autoload_register(function ($class_name) {
	global $config;
	
    if (file_exists($config["system_path"] . "/class/class.". $class_name .".php")) {
		include_once($config["system_path"] . "/class/class.". $class_name .".php");
	}
	elseif (file_exists($config["system_path"] . "/class/interface.". $class_name .".php")) {
		include_once($config["system_path"] . "/class/interface.". $class_name .".php");
	}
	elseif (file_exists($config["system_path"] . "/class/". str_replace("\\","/",$class_name) .".class.php")) {
		include_once($config["system_path"] . "/class/". str_replace("\\","/",$class_name) .".class.php");
	}
	else {
		throw new Exception("Class or Interface {$class_name} not found!");
	}
});
?>