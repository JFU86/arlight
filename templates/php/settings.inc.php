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
$settings = new Settings();
$cfg = $settings->fetch();


// Beim Ändern
if (isset($_REQUEST["submit"])) {
	header("Location: ./?action=settings");
	exit;
}


$vars = array(
		"{chkTestChecked}"		=>	"checked='checked'",
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>