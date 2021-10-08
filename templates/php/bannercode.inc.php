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
$ar = new Adrotator();

// Format auslesen
$formate = "<select name='format' id='format' onchange=\"document.location.href='?action=bannercode&amp;cid='+this.value\">";
foreach ($ar->getFormats() as $row) {
	$formate .= "<option value='{$row["id"]}'";
	if ($row["id"] == $_SESSION["format_id"]) $formate .= " selected='selected' ";
	$formate .= ">{$row["desc"]} ({$row["width"]}x{$row["height"]})</option>";
}
$formate .= "</select>";


$vars = array(
			"{scriptpath}"	=>	substr($config["scriptpath"],0,-25),
			"{format_id}"	=>	$ar->getCurrentFormat(),
			"{width}"		=>	$ar->getWidth(),
			"{height}"		=>	$ar->getHeight(),
			"{formate}"		=>	$formate,
			"{rand}"		=>	strtoupper(dechex(rand(0x0F0000, 0xFFFFFF)))
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>