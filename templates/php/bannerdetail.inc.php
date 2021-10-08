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
$xml = new XML();

// In case something is submitted
if (isset($_REQUEST["edit"]) && isset($_REQUEST["id"])) {	
	if ($_REQUEST["name"] != "" && ($_REQUEST["url"] != "" && $_REQUEST["img"] != "" && $_REQUEST["alt"] != "" || $_REQUEST["code"] != "")) {		
		$ar->editBanner($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["url"], $_REQUEST["img"], $_REQUEST["alt"], $_REQUEST["code"], $_REQUEST["format_id"]);
		header("Location: ./?action=bannerliste");
		exit;
	}
	else {
		header("Location: ./?action=bannerdetail&id=". $_REQUEST["id"]."&error=fill_all_fields");
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

// Get banner data
$data = $ar->getBanner($_REQUEST["id"]);

// Format auslesen
$formate = "";
foreach ($ar->getFormats() as $row) {
	$selected = ($data["format_id"] == $row["format_id"]) ? " selected=\"selected\"" : "";
	$notselected = ($data["format_id"] != $row["format_id"]) ? " - [{@verschieben}]" : "";
	$formate .= "<option value=\"{$row["id"]}\"{$selected}>{$row["desc"]} ({$row["width"]}x{$row["height"]}){$notselected}</option>" . "\r\n";
}

$temp = array(
		"{name}"	=>		$data["name"],
		"{url}"		=>		$data["url"],
		"{img}"		=>		$data["img"],
		"{alt}"		=>		$data["alt"],
		"{code}"	=>		$data["code"],
);

$vars = array(
		"{id}"				=>		$_REQUEST["id"],
		"{bannerdetail}"	=>		($data["code"] == "") 
									? $template->output($config["template_path"]."/html/bannerdetail.classic.html",$temp) 
									: $template->output($config["template_path"]."/html/bannerdetail.code.html",$temp),	
		"{bannerpreview}"	=>		($data["code"] != "") ? $data["code"] : "<a href=\"{$data["url"]}\" target=\"_blank\"><img src=\"{$data["img"]}\" alt=\"{$data["alt"]}\" /></a>",
		"{formate}"			=>		$formate,
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>