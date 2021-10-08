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

// Submit Insert
if (isset($_REQUEST["submit"])) {
	if ($_REQUEST["name"] != "" && $_REQUEST["code"] != "") {	
		$ar->addBanner($_REQUEST["name"],"","","",$_REQUEST["code"],$_REQUEST["format"]);
		$ar->setCurrentFormat($_REQUEST["format"]);
		header("Location: ./?action=bannerliste");
		exit;
	}
	else {
		header("Location: ./?action=bannercodeeintragen&error=fill_all_fields&name={$_REQUEST["name"]}&code={$_REQUEST["code"]}");
		exit;
	}
}

// Catch error messages!
if (isset($_REQUEST["error"])) {
	switch($_REQUEST["error"]){
		case "fill_all_fields":
			echo $template->errorbox($language->translate("Bitte alle Felder ausfüllen") . "!");
			break;
	}
}

// Format auslesen
$formate = "";
foreach ($ar->getFormats() as $row) {	
	$selected = ($ar->getCurrentFormat() == $row["format_id"]) ? " selected=\"selected\"" : "";
	$formate .= "<option value=\"{$row["id"]}\"{$selected}>{$row["desc"]} ({$row["width"]}x{$row["height"]})</option>" . "\r\n";
}

$vars = array(
		"{name}"	=> $_REQUEST["name"],
		"{code}"	=> $_REQUEST["code"],
		"{formate}" => $formate,	
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>