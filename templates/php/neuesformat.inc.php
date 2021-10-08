<?php
/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/

$template = new Template();
$language = new Language();
$ar = new Adrotator();

// Drop format action
if (isset($_REQUEST["drop"]) && isset($_REQUEST["id"])) {	
	if ($_REQUEST["id"] != 1) {
		$ar->deleteFormat($_REQUEST["id"]);
		$ar->setCurrentFormat(1);
	}
	header("Location: ./?action=bannerliste");
	exit;
}


// In case something is submitted
if ($_REQUEST["submit"] != "") {	
	if ($_REQUEST["name"] == "") {
		header("Location: ./?action=neuesformat&error=name_required&name={$_REQUEST["name"]}&width={$_REQUEST["width"]}&height={$_REQUEST["height"]}");
		exit;
	}
	elseif ((int)($_REQUEST["width"]) <= 0 || (int)($_REQUEST["height"]) <= 0) {
		header("Location: ./?action=neuesformat&error=invalid_format&name={$_REQUEST["name"]}&width={$_REQUEST["width"]}&height={$_REQUEST["height"]}");
		exit;
	}
	
	// Submit Format		
	if ($_REQUEST["name"] != "" && (int)($_REQUEST["width"]) > 0 && (int)($_REQUEST["height"]) > 0) {		
		if (($format_id = $ar->addFormat($_REQUEST["width"], $_REQUEST["height"], $_REQUEST["name"])) > 0) {
			$ar->setCurrentFormat($format_id);
			header("Location: ./?action=bannerliste");
			exit;
		}
		else {
			header("Location: ./?action=neuesformat&error=already_exists&name={$_REQUEST["name"]}&width={$_REQUEST["width"]}&height={$_REQUEST["height"]}");
			exit;
		}
	}
}


// Catch error messages!
if (isset($_REQUEST["error"])) {
	
	switch($_REQUEST["error"]){
		
		case "name_required":
			echo $template->errorbox($language->translate("Das Format muss einen Namen haben!"));
		break;
		
		case "invalid_format":
			echo $template->errorbox($language->translate("Ungültige Größenangabe") ."!");
		break;	

		case "already_exists":
			echo $template->errorbox($language->translate("Ein Format mit diesen Maßen existiert bereits!"));
		break;			
	}	
}


$vars = array(
		"{name}" => $_REQUEST["name"],
		"{width}" => $_REQUEST["width"],
		"{height}" => $_REQUEST["height"],		
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>