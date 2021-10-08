<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

// (1) Load configuration
if (file_exists("../system/config/config.inc.php")) {
	include_once("../system/config/config.inc.php");
}
else {
	include_once("../system/config/config.min.inc.php");
}

// (2) run updates if possible
if (file_exists("../system/config/config.inc.php") && file_exists($config["system_path"]."/temp/UPDATE") && !$config["debug"]) {
	$install = new Install();
	$install->databaseUpdate();
}

$template = new Template();

/**********************************************************************************
 *  check if arlight is not installed yet or if so, the install.php must be removed
 **********************************************************************************/
if (file_exists($config["basepath"]."/admin/install.php") && file_exists($config["system_path"]."/sqlite/arlight.db") && !$config["debug"]) {
	$template->getTemplate("overall_header");
	$template->getTemplate("gfxheader");
	echo "<br />";
	echo $template->errorbox("<b>Please delete 'admin/install.php' first before using ArLight !</b>");
	echo "<br />";
	$template->getTemplate("copyright");
	$template->getTemplate("overall_footer");
	exit;
}
elseif (file_exists($config["basepath"]."/admin/install.php") && !file_exists($config["system_path"]."/sqlite/arlight.db")) {
	header("Location: install.php");
	exit;
}


/***********************
 * User login validation
 ***********************/
// Login
if ($_REQUEST["submit"] != "" && isset($_REQUEST["name"]) && isset($_REQUEST["pass0"])) {
	$admin = new Admin();
	$admin->login($_REQUEST["name"],$_REQUEST["pass0"]);
	header("Location: ./");
	exit;
}
// Login-Check
if ($_SESSION["admin_id"] == null) {
	$template->getTemplate("overall_header");
	$template->getTemplate("gfxheader");
	$template->getTemplate("login");
	$template->getTemplate("copyright");
	$template->getTemplate("overall_footer");
	exit;
}


/**************************
 * Change the active format
 **************************/
if (isset($_REQUEST["cid"])) {
	$ar = new Adrotator();
	$ar->setCurrentFormat($_REQUEST["cid"]);
	header("Location: ./?action=". $_REQUEST["action"]);
	exit;
}


/*******************
 * Request templates
 *******************/
if (!$_REQUEST["noheader"]){
	$template->getTemplate("overall_header");
	$template->getTemplate("gfxheader");
	$template->getTemplate("menu");
}

switch($_REQUEST["action"]){
	default: $template->getTemplate(trim($_REQUEST["action"])); break;
	case "": $template->getTemplate("news"); break;
	case "logout": $admin = new Admin(); $admin->logout(); $template->getTemplate("login"); break;
}

$template->getTemplate("copyright");
$template->getTemplate("overall_footer");
?>