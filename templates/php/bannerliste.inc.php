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
$output = "";

// In case drop is submitted
if (isset($_REQUEST["drop"]) && isset($_REQUEST["id"])) {
	$ar->dropBanner($_REQUEST["id"]);
	header("Location: ./?action=bannerliste");
	exit;
}
// In case status is submitted
if (isset($_REQUEST["status"]) && isset($_REQUEST["id"])) {
	$ar->setBannerStatus($_REQUEST["id"]);
	header("Location: ./?action=bannerliste");
	exit;
}

// List each banner
foreach ($ar->fetchBanner($ar->clean($_REQUEST["order"]),$ar->getCurrentFormat()) as $key => $row) {
	
	$code = ($row["code"] != "") ? ($row["code"]) : "<a href=\"{$row["url"]}\" target=\"_blank\"><img src=\"{$row["img"]}\" alt=\"{$row["alt"]}\" height=\"{$ar->getHeight()}\" width=\"{$ar->getWidth()}\" /></a>";
	$status_icon = ($row["status"] == 0) ? "s_success.png" : "b_off.gif";
	$name = ($row["status"] == 0) ? "<span style='color:#FF0000;'>{$row["name"]}</span>" : $row["name"];
	if ($row["code"] != "") { $name = "<img src='../templates/img/c.png' alt='bannercode' /> " . $name; }
	
	$vars = array(
		"{id}"			=>	$row["banner_id"],
		"{status_icon}"	=>	$status_icon,
		"{name}"		=>	$name,
		"{code}"		=>	$code,
		"{adviews}"		=>	number_format($row["adviews"], 0, '.', ' '),
		"{adclicks}"	=>	number_format($row["adclicks"], 0, '.', ' '),
		"{ratio}"		=>	$row["ratio"],
	);
	
	$output .= $template->output($config["template_path"]."/html/bannerliste.item.html", $vars);
}

// Empty?
if($ar->getBannerCount() == 0){	
	$output .= "<tr>
		<td colspan=\"4\"><b>{@Es wurden noch keine Banner in diesem Format eingetragen.}</b></td>
	</tr>
	";
}

// Format auslesen
$formate = "<select name='format' id='format' onchange=\"document.location.href='?action=bannerliste&amp;cid='+this.value\">";
foreach ($ar->getFormats() as $row) {
	$formate .= "<option value='{$row["format_id"]}'";
	if ($row["id"] == $_SESSION["format_id"]) $formate .= " selected='selected' ";
	$formate .= ">{$row["desc"]} ({$row["width"]}x{$row["height"]})</option>";
}
$formate .= "</select>";

$vars = array(
			"{bannerliste}" => $output,
			"{format_id}" => $ar->getCurrentFormat(),
			"{formate}" => $formate,
);

################################################################
#### AB HIER NICHTS ÄNDERN !!! 
#### Teamplate einbinden und definierte Variablen ersetzen
################################################################

echo $template->output($template->getFilePath(__FILE__), $vars);

?>